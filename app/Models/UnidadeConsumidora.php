<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnidadeConsumidora extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'created_at',
        'updated_at',
    ];

    protected $table = 'unidades_consumidoras';

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
