<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'material_id',
        'parent_id',
        'body',
    ];

    /**
     * Comment belongs to user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Comment belongs to material
     */
    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    /**
     * Comment belongs to parent comment
     */
    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    /**
     * Comment has many children comments
     */
    public function children()
    {
        return $this->hasMany(Comment::class, 'parent_id')->with('children', 'user');
    }

    /**
     * Check if comment is a root comment
     */
    public function isRoot(): bool
    {
        return is_null($this->parent_id);
    }

    /**
     * Get all replies count
     */
    public function getRepliesCountAttribute(): int
    {
        return $this->children()->count();
    }
} 