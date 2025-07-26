<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MaterialResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'judul' => $this->judul,
            'deskripsi' => $this->deskripsi,
            'tipe' => $this->tipe,
            'file_url' => $this->getFileUrl(),
            'status' => $this->status,
            'course' => new CourseResource($this->whenLoaded('course')),
            'user' => new UserResource($this->whenLoaded('user')),
            'comments' => CommentResource::collection($this->whenLoaded('rootComments')),
            'comments_count' => $this->when($this->comments()->exists(), $this->comments()->count()),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }

    /**
     * Get the file URL based on material type
     */
    private function getFileUrl()
    {
        if ($this->tipe === 'article') {
            return $this->file_url; // HTML content
        }
        
        return $this->file_url ? asset('storage/' . $this->file_url) : null;
    }
} 