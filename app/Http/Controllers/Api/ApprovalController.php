<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Material;
use App\Models\Approval;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApprovalController extends Controller
{
    /**
     * Display pending materials for approval
     */
    public function index(Request $request)
    {
        $query = Material::pending()->with(['course', 'user']);

        // Type filter
        if ($request->has('tipe')) {
            $query->where('tipe', $request->tipe);
        }

        // Course filter
        if ($request->has('course_id')) {
            $query->where('course_id', $request->course_id);
        }

        $perPage = $request->get('per_page', 15);
        $materials = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => [
                'pending_materials' => $materials->items(),
                'pagination' => [
                    'current_page' => $materials->currentPage(),
                    'last_page' => $materials->lastPage(),
                    'per_page' => $materials->perPage(),
                    'total' => $materials->total(),
                    'from' => $materials->firstItem(),
                    'to' => $materials->lastItem()
                ]
            ]
        ]);
    }

    /**
     * Display the specified material for review
     */
    public function show(Material $material)
    {
        $material->load(['course', 'user', 'approval.admin']);

        return response()->json([
            'success' => true,
            'data' => [
                'material' => $material
            ]
        ]);
    }

    /**
     * Update material status (approve/reject)
     */
    public function update(Request $request, Material $material)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:approved,rejected'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        // Update material status
        $material->update(['status' => $request->status]);

        // Create or update approval record
        Approval::updateOrCreate(
            ['material_id' => $material->id],
            [
                'admin_id' => auth()->id(),
                'status' => $request->status
            ]
        );

        $material->load(['course', 'user', 'approval.admin']);

        return response()->json([
            'success' => true,
            'message' => 'Material ' . $request->status . ' successfully',
            'data' => [
                'material' => $material
            ]
        ]);
    }

    /**
     * Get admin statistics
     */
    public function stats()
    {
        $stats = [
            'total_courses' => Course::count(),
            'approved_courses' => Course::approved()->count(),
            'pending_courses' => Course::where('status', 'pending')->count(),
            
            'total_materials' => Material::count(),
            'approved_materials' => Material::approved()->count(),
            'pending_materials' => Material::pending()->count(),
            
            'total_users' => User::count(),
            'admin_users' => User::where('role', 'admin')->count(),
            'regular_users' => User::where('role', 'user')->count(),
            
            'materials_by_type' => Material::approved()
                ->selectRaw('tipe, count(*) as count')
                ->groupBy('tipe')
                ->pluck('count', 'tipe'),
                
            'courses_by_category' => Course::approved()
                ->selectRaw('kategori, count(*) as count')
                ->whereNotNull('kategori')
                ->groupBy('kategori')
                ->pluck('count', 'kategori'),
                
            'recent_activities' => [
                'recent_materials' => Material::with(['course', 'user'])
                    ->orderBy('created_at', 'desc')
                    ->limit(5)
                    ->get(),
                'recent_courses' => Course::with('user')
                    ->orderBy('created_at', 'desc')
                    ->limit(5)
                    ->get()
            ]
        ];

        return response()->json([
            'success' => true,
            'data' => [
                'stats' => $stats
            ]
        ]);
    }
} 