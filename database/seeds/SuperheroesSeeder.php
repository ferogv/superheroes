<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SuperheroesSeeder extends Seeder
{
    public function run()
    {
        // Inserta 10 registros; ajusta los nombres de columnas si tu tabla usa otros
        for ($i = 1; $i <= 10; $i++) {
            DB::table('superheroes')->insert([
                'real_name'  => "Real Name {$i}",
                'hero_name'  => "Hero {$i}",
                // Asegúrate de tener estos archivos en storage/app/public/Avatars/IMG{$i}.jpg
                'photo_url'  => "Avatars/IMG{$i}.jpg",
                'description'=> "Demo hero {$i}",
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
