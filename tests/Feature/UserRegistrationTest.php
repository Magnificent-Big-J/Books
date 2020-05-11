<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class UserRegistrationTest extends TestCase
{
    use RefreshDatabase;

    /** @test **/
    public function can_create_admin_user()
    {
        Mail::fake();

        $this->authenticateAdmin();
        $response = $this->post('/admin/register-employee', array_merge($this->postUserData(),['type'=> 1]));
        $response->assertStatus(200);

        $this->assertDatabaseHas('users',
            ['name' => $this->postUserData()['name']
        ]);
        $user = User::find(1);
        $this->assertTrue(User::count() > 0);
        $this->assertTrue($user->hasRole('Admin'));
    }
    /** @test **/
    public function can_create_sales_user()
    {
        $this->authenticateAdmin();
        $response = $this->post('/admin/register-employee', array_merge($this->postUserData(),['type'=> 2]));
        $response->assertStatus(200);

        $this->assertDatabaseHas('users',
            ['name' => $this->postUserData()['name']
            ]);
        $user = User::find(2);
        $this->assertTrue(User::count() > 0);
        $this->assertTrue($user->hasRole('Sale'));
    }
    /** @test **/
    public function can_create_customer_user()
    {
        $this->authenticateAdmin();
        $response = $this->post('/admin/register-employee', array_merge($this->postUserData(),['type'=> 3]));
        $response->assertStatus(200);

        $this->assertDatabaseHas('users',
            ['name' => $this->postUserData()['name']
            ]);
        $user = User::find(2);
        $this->assertTrue(User::count() > 0);
        $this->assertTrue($user->hasRole('Customer'));
    }

    /** @test */
    public function name_is_required()
    {
        $this->authenticateAdmin();
        $this->post('/admin/register-employee',
            array_merge($this->postUserData(),['name'=> null]))->assertSessionHasErrors('name');
        $this->assertCount(1, User::all());
    }
    /** @test */
    public function email_is_required()
    {
        $this->authenticateAdmin();
        $this->post('/admin/register-employee',
            array_merge($this->postUserData(),['email'=> null]))->assertSessionHasErrors('email');
        $this->assertCount(1, User::all());
    }
    /** @test */
    public function password_is_required()
    {
        $this->authenticateAdmin();
        $this->post('/admin/register-employee',
            array_merge($this->postUserData(),['password'=> null]))->assertSessionHasErrors('password');
        $this->assertCount(1, User::all());
    }
    /** @test */
    public function sales_person_cannot_create_a_user()
    {
        $this->authenticateSales();
        $response = $this->post('/admin/register-employee', array_merge($this->postUserData(),['type'=> 2]));
        $response->assertRedirect(route('home'));
        $this->assertCount(1, User::all());
    }
}
