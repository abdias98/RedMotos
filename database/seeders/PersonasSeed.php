<?php

namespace Database\Seeders;

use App\Models\Persona;
use Illuminate\Database\Seeder;

class PersonasSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Persona::create([
            'nombres' => 'Abdias Ismael',
            'apellidos' => 'Velasquez Gonzalez',
            'sexo' => 'M',
            'fecha_nacimiento' => '2023-02-04',
            'correo_electronico' => 'abdiasv32@gmail.com',
            'telefono' => '95989467'
        ]);
    }
}
