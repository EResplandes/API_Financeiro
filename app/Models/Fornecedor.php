<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Banco;

class Fornecedor extends Model
{
    use HasFactory;

    protected $table = 'fornecedores';

    protected $fillable = ['nome', 'nome_fantasia', 'cnpj', 'login', 'senha', 'fk_banco'];


    public function banco()
    {
        return $this->hasOne(Banco::class, 'id', 'fk_banco');
    }
}
