<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $materials = Material::with(['course', 'user'])
            ->approved()
            ->latest()
            ->paginate(12);

        return view('materials.index', compact('materials'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Debug: Log that we reached this method
        \Log::info('MaterialController@create accessed by user: ' . (auth()->check() ? auth()->user()->email : 'guest'));
        
        $courses = Course::approved()->get();
        
        // Debug: Log courses count
        \Log::info('Available courses count: ' . $courses->count());
        
        return view('materials.create', compact('courses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validationRules = [
            'course_id' => 'required|exists:courses,id',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tipe' => 'required|in:video,pdf,audio,image,article',
        ];

        // Add conditional validation based on type
        if ($request->tipe === 'article') {
            // For article type, require content
            $validationRules['content'] = 'required|string|min:10';
        } else {
            // For non-article types, require file and set PHP upload limit (2MB = 2048KB)
            switch ($request->tipe) {
                case 'video':
                    $validationRules['file'] = 'required|file|mimes:mp4,avi,mov,wmv,flv,mkv|max:10240'; // 10MB max (but limited by PHP upload_max_filesize)
                    break;
                case 'pdf':
                    $validationRules['file'] = 'required|file|mimes:pdf|max:2048'; // 2MB max due to PHP limit
                    break;
                case 'audio':
                    $validationRules['file'] = 'required|file|mimes:mp3,wav,aac,ogg|max:2048'; // 2MB max due to PHP limit
                    break;
                case 'image':
                    $validationRules['file'] = 'required|file|mimes:jpeg,png,jpg,gif,webp|max:2048'; // 2MB max due to PHP limit
                    break;
                default:
                    $validationRules['file'] = 'required|file|max:2048'; // 2MB max due to PHP limit
            }
        }

        $request->validate($validationRules);

        try {
            $data = $request->only(['course_id', 'judul', 'deskripsi', 'tipe']);
            $data['user_id'] = auth()->id();
            $data['status'] = 'pending'; // Explicitly set status

            if ($request->tipe === 'article') {
                $data['file_url'] = $request->content;
            } else {
                if (!$request->hasFile('file')) {
                    return redirect()->back()
                        ->withErrors(['file' => 'File is required for this material type.'])
                        ->withInput();
                }

                $file = $request->file('file');
                $filename = time() . '_' . $file->getClientOriginalName();
                $data['file_url'] = $file->storeAs('materials', $filename, 'public');
            }

            Material::create($data);

            return redirect()->route('materials.index')
                ->with('success', 'Material uploaded successfully and pending approval!');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Failed to upload material: ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Material $material)
    {
        // Only show approved materials to non-owners and non-admins
        if ($material->status !== 'approved' && 
            $material->user_id !== auth()->id() && 
            !auth()->user()->isAdmin()) {
            abort(404);
        }

        $material->load(['course', 'user', 'rootComments.user']);

        return view('materials.show', compact('material'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Material $material)
    {
        $this->authorize('update', $material);
        $courses = Course::approved()->get();
        return view('materials.edit', compact('material', 'courses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Material $material)
    {
        $this->authorize('update', $material);

        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tipe' => 'required|in:video,pdf,audio,image,article',
            'file' => 'nullable|file|max:10240',
            'content' => 'required_if:tipe,article',
        ]);

        $data = $request->all();

        if ($request->tipe === 'article') {
            $data['file_url'] = $request->content;
        } elseif ($request->hasFile('file')) {
            // Delete old file if it's not an article
            if ($material->tipe !== 'article' && $material->file_url) {
                Storage::disk('public')->delete($material->file_url);
            }
            
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $data['file_url'] = $file->storeAs('materials', $filename, 'public');
        }

        // Reset status to pending when material is updated
        $data['status'] = 'pending';

        $material->update($data);

        return redirect()->route('materials.show', $material)
            ->with('success', 'Material updated successfully and pending approval!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Material $material)
    {
        $this->authorize('delete', $material);

        if ($material->tipe !== 'article' && $material->file_url) {
            Storage::disk('public')->delete($material->file_url);
        }

        $material->delete();

        return redirect()->route('materials.index')
            ->with('success', 'Material deleted successfully!');
    }
} 