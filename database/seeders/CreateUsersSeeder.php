<?php

namespace Database\Seeders;
use App\Models\User;

use Illuminate\Database\Seeder;
use Illuminate\Foundation\Auth\User as AuthUser;

class CreateUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user =[
            [
                'name'     => 'User',
                'username' => 'User',
                'email'    => 'user@gmail.com',
                'password' => bcrypt('12345'),
                'photo'    =>'user.jpg',
                'roles_id' => 2
            ],
            [
                'name'     => 'Admin',
                'username' => 'Admin',
                'email'    => 'admin@gmail.com',
                'password' => bcrypt('12345'),
                'photo'    =>'admin.jpg',
                'roles_id' => 1
            ]
        ];
        foreach ($user as $key => $value){
            User::create($value);
        }
    }
}