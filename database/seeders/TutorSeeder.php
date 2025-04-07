<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Tutor;

class TutorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tutorUsers = User::where('role_id', 4)->get();
        $centros = ['IES Example 1', 'IES Example 2', 'IES Example 3'];

        foreach ($tutorUsers as $user) {
            Tutor::create([
                'id' => $user->id,
                'centro_asignado' => $centros[array_rand($centros)],
            ]);
        }
    }
}
