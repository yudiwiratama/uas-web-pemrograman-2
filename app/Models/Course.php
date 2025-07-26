<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'deskripsi',
        'thumbnail',
        'kategori',
        'status',
        'user_id',
    ];

    /**
     * Course belongs to user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Course has many materials
     */
    public function materials()
    {
        return $this->hasMany(Material::class);
    }

    /**
     * Get approved materials
     */
    public function approvedMaterials()
    {
        return $this->hasMany(Material::class)->where('status', 'approved');
    }

    /**
     * Scope for approved courses
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }
} 