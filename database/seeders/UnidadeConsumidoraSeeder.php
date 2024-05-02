<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\UnidadeConsumidora;

class UnidadeConsumidoraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Gerar 30 unidades consumidoras fictícias
        \App\Models\UnidadeConsumidora::factory(30)->create();
    }
}
