<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Chambre extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Chambre::create([
            'id_chambre' => 0,
            'nom_chambre' => null,
        ]);
    }
}
