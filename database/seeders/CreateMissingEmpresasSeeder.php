<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Empresa;

class CreateMissingEmpresasSeeder extends Seeder
{
    public function run()
    {
        // Obtener todos los usuarios de tipo empresa que no tienen registro en la tabla empresa
        $empresaUsers = User::where('role_id', 2)
            ->whereDoesntHave('empresa')
            ->get();

        foreach ($empresaUsers as $user) {
            Empresa::create([
                'user_id' => $user->id,
                'show_cif' => false
            ]);
        }
    }
} 