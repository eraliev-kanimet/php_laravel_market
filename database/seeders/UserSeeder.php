<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Throwable;

class UserSeeder extends Seeder
{
    /**
     * @throws Throwable
     */
    public function run()
    {
        Role::create([
            'title' => 'Administrator',
            'slug' => 'admin'
        ]);
        Role::create([
            'title' => 'Seller',
            'slug' => 'seller'
        ]);
        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@admin.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ]);
        $admin->roles()->attach(1);
        User::factory()->count(10)->create();
    }
}
