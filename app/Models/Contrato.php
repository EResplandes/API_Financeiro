<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contrato extends Model
{
    use HasFactory;

    protected $fillable = [
        'servico',
        'contrato',
        'qtd_parcelas',
        'valor_contrato',
        'fk_empresa',
        'fk_unidade',
        'fk_fornecedor'
    ];

    protected $table = 'contratos';

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
