<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

         $user1 = User::factory()->create([
             'name' => 'Admin',
             'email' => 'admin@example.com',
             'photo' => '/Users/amberborici/Downloads/alien.jpg',
             'description' => 'Admin of the page',
             'location' => 'Shkoder',
             'phone_number' => '+355699577766'

         ]);

        $role = Role::create(['name'=>'admin']);
        $user1->assignRole($role);
    }
}
