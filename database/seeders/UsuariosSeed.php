<?php

namespace Database\Seeders;

use App\Http\Livewire\Usuarios;
use App\Models\User;
use Illuminate\Database\Seeder;

class UsuariosSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /** Usuario administrador para poder acceder al sistema inicialmente **/
        $users = User::create([
            'name' => 'Abdias',
            'id_persona' => 1,
            'password' => bcrypt('abdias000')
        ])->assignRole('Administrador');

    }
}
