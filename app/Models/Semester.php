<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    public function pendaftar()
    {
        return $this->belongsTo(Pendaftar::class);
    }
    use HasFactory;
}