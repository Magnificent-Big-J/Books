<?php

use App\Role;
use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin_role = Role::where('name','Admin')->first();
        $sale_role = Role::where('name','Sale')->first();
        $customer_role = Role::where('name','Customer')->first();

        $admin = User::create([
            'name' => 'Jade Sinnot',
            'email' => 'jade@example.com',
            'password' => bcrypt('password')
        ]);
        $admin->roles()->attach($admin_role);

        $sale = User::create([
            'name' => 'Gerald Shoe',
            'email' => 'gerald@example.com',
            'password' => bcrypt('password')
        ]);
        $sale->roles()->attach($sale_role);
        $customer = User::create([
            'name' => 'Alison Parker',
            'email' => 'alison@example.com',
            'password' => bcrypt('password')
        ]);
        $customer->roles()->attach($customer_role);
    }
}
