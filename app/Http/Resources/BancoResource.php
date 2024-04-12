<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BancoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            "id"                => $this->id,
            "cod_banco"         => $this->cod_banco,
            "agencia"           => $this->agencia,
            "conta"             => $this->conta,
            "descricao_banco"   => $this->descricao_banco
        ];
    }
}
