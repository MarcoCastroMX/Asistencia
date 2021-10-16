<?php

namespace Database\Seeders;

use App\Models\Area;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("areas")->insert([
            "nombre_area"=> "Rectoria",
            "titular" => "Ruth Padilla",
            "informacion" => "Protocolo rectoria",
            "telefono" => "1234567"
        ]);

        Area::create([
            "nombre_area"=> "Coord. Computacion",
            "titular" => "Martha",
            "informacion" => "Ayuda en procesos",
            "telefono" => "98765"
        ]);

        Area::factory(20)->create();
    }
}
