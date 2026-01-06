<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{
    use HasFactory;

    // Tambahin ini biar datanya bisa masuk pas Holiday::create()
    protected $fillable = [
        'holiday_date',
        'description',
        'type'
    ];
}