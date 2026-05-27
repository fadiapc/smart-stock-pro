<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    use HasFactory;

    // Buka gemboknya di sini:
    protected $fillable = [
        'name',
        'location',
        'lat',
        'lng',
        'capacity',
    ];
}