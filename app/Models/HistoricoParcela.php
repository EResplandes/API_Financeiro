<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoricoParcela extends Model
{
    use HasFactory;

    protected $table = 'historico_parcelas';

    protected $fillable = [
        'data_status',
        'fk_parcela',
        'observacao',
    ];

}
