<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parcela extends Model
{
    use HasFactory;

    protected $table = 'parcelas';

    protected $fillable = [
        'fk_contrato',
        'mes_referencia',
        'dt_vencimento',
        'observacao',
        'valor'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
