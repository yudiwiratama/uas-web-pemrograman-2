<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'judul',
        'deskripsi',
        'tipe',
        'file_url',
        'status',
        'user_id',
    ];

    /**
     * Material belongs to course
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Material belongs to user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Material has many comments
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Material has one approval
     */
    public function approval()
    {
        return $this->hasOne(Approval::class);
    }

    /**
     * Get root comments (parent comments)
     */
    public function rootComments()
    {
        return $this->hasMany(Comment::class)->whereNull('parent_id')->with('children');
    }

    /**
     * Scope for approved materials
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope for pending materials
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
} 