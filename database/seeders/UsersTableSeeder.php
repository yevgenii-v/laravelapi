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

        $admin->roles()->attach($adminRole);

        for ($i=1; $i<=4; $i++) {
            $support = User::create([
                'name'      => 'Support0'.$i,
                'email'     => 'support0'.$i.'@laravel.loc',
                'password'  => 'support0'.$i.'secret',
            ]);

            $support->roles()->sync($supportRole);
        }

        $user = User::create([
            'name'      => 'User',
            'email'     => 'user@laravel.loc',
            'password'  => 'usersecret',
        ]);

        $user->roles()->attach($userRole);
    }
}
