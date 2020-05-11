<?php

namespace Tests;

use App\Role;
use App\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function postUserData()
    {
        return [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'password' => bcrypt('password')
        ];
    }
    private function createRoles()
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
    public function authenticateAdmin()
    {
        $user = factory(User::class)->create();
        $this->createRoles();
        $role = Role::where('name', 'Admin')->first();
        $user->roles()->attach($role);
        $this->actingAs($user);
    }
    public function authenticateSales()
    {
        $user = factory(User::class)->create();
        $this->createRoles();
        $role = Role::where('name', 'Sale')->first();
        $user->roles()->attach($role);
        $this->actingAs($user);
    }
}
