<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    use HasFactory;

    // INI KUNCI GEMBOKNYA: Daftarkan kolom yang boleh diisi otomatis
    protected $fillable = [
        'user_name',
        'action',
        'ip_address',
    ];
}