<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        User::truncate();
        Schema::enableForeignKeyConstraints();

        $adminRole = Role::where('name', 'Administrator')->first();
        $supportRole = Role::where('name', 'Support')->first();
        $userRole = Role::where('name', 'User')->first();

        $admin = User::create([
            'name'      => 'Admin',
            'email'     => 'admin@laravel.loc',
            'password'  => 'adminsecret',
        ]);

        $support = User::create([
            'name'      => 'Support',
            'email'     => 'support@laravel.loc',
            'password'  => 'supportsecret',
        ]);

        $user = User::create([
            'name'      => 'User',
            'email'     => 'user@laravel.loc',
            'password'  => 'usersecret',
        ]);

        $admin->roles()->attach($adminRole);
        $support->roles()->attach($supportRole);
        $user->roles()->attach($userRole);
    }
}
