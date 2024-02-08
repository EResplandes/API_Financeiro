<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;

    protected $fillable = [
        'empresa',
        'cnpj',
        'created_at',
        'updated_at',
    ];

    protected $table = 'empresas';

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
