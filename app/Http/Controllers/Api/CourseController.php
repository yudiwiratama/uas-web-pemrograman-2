<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CourseController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of courses
     */
    public function index(Request $request)
    {
        $query = Course::approved()->with(['user', 'materials' => function($q) {
            $q->approved();
        }]);

        // Search filter
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul', 'LIKE', "%{$search}%")
                  ->orWhere('deskripsi', 'LIKE', "%{$search}%")
                  ->orWhere('kategori', 'LIKE', "%{$search}%");
            });
        }

        // Category filter
        if ($request->has('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        $perPage = $request->get('per_page', 15);
        $courses = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => [
                'courses' => $courses->items(),
                'pagination' => [
                    'current_page' => $courses->currentPage(),
                    'last_page' => $courses->lastPage(),
                    'per_page' => $courses->perPage(),
                    'total' => $courses->total(),
                    'from' => $courses->firstItem(),
                    'to' => $courses->lastItem()
                ]
            ]
        ]);
    }

    /**
     * Store a newly created course
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'kategori' => 'nullable|string|max:255',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
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

        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $filename = time() . '_' . $file->getClientOriginalName();
            $data['thumbnail'] = $file->storeAs('thumbnails', $filename, 'public');
        }

        $course = Course::create($data);
        $course->load('user');

        return response()->json([
            'success' => true,
            'message' => 'Course created successfully',
            'data' => [
                'course' => $course
            ]
        ], 201);
    }

    /**
     * Display the specified course
     */
    public function show(Course $course)
    {
        // Authorization check
        if ($course->status !== 'approved' && 
            $course->user_id !== auth()->id() && 
            (!auth()->check() || !auth()->user()->isAdmin())) {
            return response()->json([
                'success' => false,
                'message' => 'Course not found or not authorized'
            ], 404);
        }

        $course->load(['user', 'materials' => function($query) {
            $query->approved()->with('user');
        }]);

        return response()->json([
            'success' => true,
            'data' => [
                'course' => $course
            ]
        ]);
    }

    /**
     * Update the specified course
     */
    public function update(Request $request, Course $course)
    {
        $this->authorize('update', $course);

        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'kategori' => 'nullable|string|max:255',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
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

        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail
            if ($course->thumbnail) {
                Storage::disk('public')->delete($course->thumbnail);
            }
            
            $file = $request->file('thumbnail');
            $filename = time() . '_' . $file->getClientOriginalName();
            $data['thumbnail'] = $file->storeAs('thumbnails', $filename, 'public');
        }

        $course->update($data);
        $course->load('user');

        return response()->json([
            'success' => true,
            'message' => 'Course updated successfully',
            'data' => [
                'course' => $course
            ]
        ]);
    }

    /**
     * Remove the specified course
     */
    public function destroy(Course $course)
    {
        $this->authorize('delete', $course);

        // Delete thumbnail
        if ($course->thumbnail) {
            Storage::disk('public')->delete($course->thumbnail);
        }

        $course->delete();

        return response()->json([
            'success' => true,
            'message' => 'Course deleted successfully'
        ]);
    }
} 