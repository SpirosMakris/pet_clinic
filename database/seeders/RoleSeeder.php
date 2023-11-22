<?php

namespace Database\Seeders;

use App\Models\Role;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Factories\Sequence;


class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::factory(4)
            ->state(new Sequence(
                ['name' => 'admin', 'description' => 'Administrator User'],
                ['name' => 'doctor', 'description' => 'Vet'],
                ['name' => 'owner', 'description' => 'Pet Owner'],
                ['name' => 'staff', 'description' => 'Clinic Staff'],
            ))
            ->create();
    }
}
