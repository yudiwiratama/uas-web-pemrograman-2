<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Material;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class MaterialController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of materials
     */
    public function index(Request $request)
    {
        $query = Material::approved()->with(['course', 'user']);

        // Course filter
        if ($request->has('course_id')) {
            $query->where('course_id', $request->course_id);
        }

        // Type filter
        if ($request->has('tipe')) {
            $query->where('tipe', $request->tipe);
        }

        // Search filter
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul', 'LIKE', "%{$search}%")
                  ->orWhere('deskripsi', 'LIKE', "%{$search}%");
            });
        }

        $perPage = $request->get('per_page', 15);
        $materials = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => [
                'materials' => $materials->items(),
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
     * Store a newly created material
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'course_id' => 'required|exists:courses,id',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tipe' => 'required|in:video,pdf,audio,image,article',
            'file' => 'required_unless:tipe,article|file|max:10240',
            'content' => 'required_if:tipe,article|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $request->all();
        $data['user_id'] = auth()->id();
        $data['status'] = 'pending';

        if ($request->tipe === 'article') {
            $data['file_url'] = $request->content;
        } else {
            if (!$request->hasFile('file')) {
                return response()->json([
                    'success' => false,
                    'message' => 'File is required for non-article materials'
                ], 422);
            }

            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $data['file_url'] = $file->storeAs('materials', $filename, 'public');
        }

        $material = Material::create($data);
        $material->load(['course', 'user']);

        return response()->json([
            'success' => true,
            'message' => 'Material uploaded successfully and pending approval',
            'data' => [
                'material' => $material
            ]
        ], 201);
    }

    /**
     * Display the specified material
     */
    public function show(Material $material)
    {
        // Authorization check
        if ($material->status !== 'approved' && 
            $material->user_id !== auth()->id() && 
            (!auth()->check() || !auth()->user()->isAdmin())) {
            return response()->json([
                'success' => false,
                'message' => 'Material not found or not authorized'
            ], 404);
        }

        $material->load(['course', 'user', 'rootComments.user']);

        return response()->json([
            'success' => true,
            'data' => [
                'material' => $material
            ]
        ]);
    }

    /**
     * Update the specified material
     */
    public function update(Request $request, Material $material)
    {
        $this->authorize('update', $material);

        $validator = Validator::make($request->all(), [
            'course_id' => 'required|exists:courses,id',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tipe' => 'required|in:video,pdf,audio,image,article',
            'file' => 'nullable|file|max:10240',
            'content' => 'required_if:tipe,article|string',
            'status' => 'sometimes|in:pending,approved'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $request->all();

        // Only admin can change status
        if (!auth()->user()->isAdmin()) {
            unset($data['status']);
        }

        if ($request->tipe === 'article') {
            $data['file_url'] = $request->content;
        } else {
            if ($request->hasFile('file')) {
                // Delete old file
                if ($material->tipe !== 'article' && $material->file_url) {
                    Storage::disk('public')->delete($material->file_url);
                }
                
                $file = $request->file('file');
                $filename = time() . '_' . $file->getClientOriginalName();
                $data['file_url'] = $file->storeAs('materials', $filename, 'public');
            }
        }

        $material->update($data);
        $material->load(['course', 'user']);

        return response()->json([
            'success' => true,
            'message' => 'Material updated successfully',
            'data' => [
                'material' => $material
            ]
        ]);
    }

    /**
     * Remove the specified material
     */
    public function destroy(Material $material)
    {
        $this->authorize('delete', $material);

        // Delete file
        if ($material->tipe !== 'article' && $material->file_url) {
            Storage::disk('public')->delete($material->file_url);
        }

        $material->delete();

        return response()->json([
            'success' => true,
            'message' => 'Material deleted successfully'
        ]);
    }
} 