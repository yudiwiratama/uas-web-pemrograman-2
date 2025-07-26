<?php

namespace App\Http\Controllers;

use App\Models\Approval;
use App\Models\Material;
use Illuminate\Http\Request;

class ApprovalController extends Controller
{
    /**
     * Display a listing of pending materials for approval.
     */
    public function index()
    {
        $pendingMaterials = Material::with(['course', 'user'])
            ->pending()
            ->latest()
            ->paginate(10);

        return view('admin.approvals.index', compact('pendingMaterials'));
    }

    /**
     * Approve or reject a material.
     */
    public function update(Request $request, Material $material)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
        ]);

        // Update material status
        $material->update(['status' => $request->status]);

        // Create approval record
        Approval::create([
            'material_id' => $material->id,
            'admin_id' => auth()->id(),
            'status' => $request->status,
        ]);

        $message = $request->status === 'approved' 
            ? 'Material approved successfully!' 
            : 'Material rejected successfully!';

        return redirect()->route('approvals.index')
            ->with('success', $message);
    }

    /**
     * Show material detail for approval review.
     */
    public function show(Material $material)
    {
        $material->load(['course', 'user']);
        return view('admin.approvals.show', compact('material'));
    }
} 