<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CommentController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display comments for a specific material
     */
    public function index(Material $material)
    {
        $comments = Comment::where('material_id', $material->id)
            ->whereNull('parent_id')
            ->with(['user', 'children.user', 'children.children.user'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return response()->json([
            'success' => true,
            'data' => [
                'comments' => $comments->items(),
                'pagination' => [
                    'current_page' => $comments->currentPage(),
                    'last_page' => $comments->lastPage(),
                    'per_page' => $comments->perPage(),
                    'total' => $comments->total(),
                    'from' => $comments->firstItem(),
                    'to' => $comments->lastItem()
                ]
            ]
        ]);
    }

    /**
     * Store a new comment
     */
    public function store(Request $request, Material $material)
    {
        $validator = Validator::make($request->all(), [
            'body' => 'required|string',
            'parent_id' => 'nullable|exists:comments,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        // Validate parent comment belongs to same material
        if ($request->parent_id) {
            $parentComment = Comment::find($request->parent_id);
            if ($parentComment->material_id !== $material->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Parent comment does not belong to this material'
                ], 422);
            }
        }

        $comment = Comment::create([
            'user_id' => auth()->id(),
            'material_id' => $material->id,
            'parent_id' => $request->parent_id,
            'body' => $request->body
        ]);

        $comment->load('user');

        return response()->json([
            'success' => true,
            'message' => 'Comment added successfully',
            'data' => [
                'comment' => $comment
            ]
        ], 201);
    }

    /**
     * Update the specified comment
     */
    public function update(Request $request, Comment $comment)
    {
        $this->authorize('update', $comment);

        $validator = Validator::make($request->all(), [
            'body' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $comment->update([
            'body' => $request->body
        ]);

        $comment->load('user');

        return response()->json([
            'success' => true,
            'message' => 'Comment updated successfully',
            'data' => [
                'comment' => $comment
            ]
        ]);
    }

    /**
     * Remove the specified comment
     */
    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);

        $comment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Comment deleted successfully'
        ]);
    }
} 