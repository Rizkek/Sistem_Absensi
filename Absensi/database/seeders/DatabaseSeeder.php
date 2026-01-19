<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Group;
use App\Models\Student;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin / BKAP
        User::factory()->create([
            'name' => 'Admin BKAP',
            'email' => 'admin@bkap.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Mentor 1
        $mentor = User::factory()->create([
            'name' => 'Ustadz Ahmad',
            'email' => 'ahmad@mentor.com',
            'password' => Hash::make('password'),
            'role' => 'mentor',
        ]);

        // Group UPA-A1
        $group = Group::create([
            'name' => 'UPA-A1',
            'mentor_id' => $mentor->id,
        ]);

        // Students
        Student::factory(12)->create([
            'group_id' => $group->id,
        ]);

        // Mentor 2
        User::factory()->create([
            'name' => 'Ustadz Budi',
            'email' => 'budi@mentor.com',
            'password' => Hash::make('password'),
            'role' => 'mentor',
        ]);
    }
}
