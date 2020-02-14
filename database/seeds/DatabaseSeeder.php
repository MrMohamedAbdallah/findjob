<?php

use App\Role;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        
        // Create roles
        $roles = ['user', 'admin', 'root'];
        foreach($roles as $roleName){
            $role = new Role([
                'name'  => $roleName
            ]);
            $role->save();
        }
        // Create Root User
        factory(App\User::class, 1)->create()->each(function($root){
            $root->email = "root@example.com";
            $root->save();
            $root->roles()->attach([1,2,3]);    // Attach all roots
        });

        factory(App\User::class, 50)->create()->each(function($user){
            $user->roles()->attach(1);
        });

        
    }
}
