<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
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
            'thumbnail' => $this->thumbnail ? asset('storage/' . $this->thumbnail) : null,
            'kategori' => $this->kategori,
            'status' => $this->status,
            'user' => new UserResource($this->whenLoaded('user')),
            'materials' => MaterialResource::collection($this->whenLoaded('materials')),
            'materials_count' => $this->when($this->materials()->exists(), $this->materials()->count()),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
} 