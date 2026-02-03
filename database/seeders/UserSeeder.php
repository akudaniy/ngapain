<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $newUsers = [
            [
                'name' => 'it manager',
                'email' => 'itmgr@gb.id',
                'password' => bcrypt('password'),
                'role' => 'manager',
            ],
            [
                'name' => 'rohiq',
                'email' => 'rohiq@gb.id',
                'password' => bcrypt('password'),
                'role' => 'supervisor',
            ],
            [
                'name' => 'ahyar',
                'email' => 'ahyar@gb.id',
                'password' => bcrypt('password'),
                'role' => 'leader',
            ],
            [
                'name' => 'rosyid',
                'email' => 'rosyid@gb.id',
                'password' => bcrypt('password'),
                'role' => 'leader',
            ],
            [
                'name' => 'yusseno',
                'email' => 'yusseno@gb.id',
                'password' => bcrypt('password'),
                'role' => 'staff',
            ],
            [
                'name' => 'nizar',
                'email' => 'nizar@gb.id',
                'password' => bcrypt('password'),
                'role' => 'staff',
            ],
            [
                'name' => 'rahma',
                'email' => 'rahma@gb.id',
                'password' => bcrypt('password'),
                'role' => 'observer',
            ],
        ];

        foreach ($newUsers as $newUser) {
            $user = User::firstOrCreate(['email' => $newUser['email']], [
                'name' => $newUser['name'],
                'email' => $newUser['email'],
                'password' => $newUser['password'],
            ]);
            $user->assignRole($newUser['role']);
        }
    }
}
