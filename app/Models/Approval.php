<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Approval extends Model
{
    use HasFactory;

    protected $fillable = [
        'material_id',
        'admin_id',
        'status',
    ];

    /**
     * Approval belongs to material
     */
    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    /**
     * Approval belongs to admin (user)
     */
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
} 