<?php

use App\Role;
use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = array(
            array('name'=>'Admin','description'=>'Admin User'),
            array('name'=>'Sale','description'=>'Sales User'),
            array('name'=>'Customer','description'=>'Customer User'),
        );

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
