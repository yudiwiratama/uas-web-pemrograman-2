<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Material;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'material_id' => 'required|exists:materials,id',
            'parent_id' => 'nullable|exists:comments,id',
            'body' => 'required|string|max:1000',
        ]);

        $comment = Comment::create([
            'user_id' => auth()->id(),
            'material_id' => $request->material_id,
            'parent_id' => $request->parent_id,
            'body' => $request->body,
        ]);

        $material = Material::find($request->material_id);

        return redirect()->route('materials.show', $material)
            ->with('success', 'Comment added successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        $this->authorize('update', $comment);
        return view('comments.edit', compact('comment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        $this->authorize('update', $comment);

        $request->validate([
            'body' => 'required|string|max:1000',
        ]);

        $comment->update($request->only('body'));

        return redirect()->route('materials.show', $comment->material)
            ->with('success', 'Comment updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);

        $materialId = $comment->material_id;
        $comment->delete();

        return redirect()->route('materials.show', $materialId)
            ->with('success', 'Comment deleted successfully!');
    }
} 