<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserLogin extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_correct_response_after_user_successfully_logins()
    {
        $user = factory(User::class)->create();

       $this->post(route('login'),[
            'email' => $user->email,
            'password' => 'password'
        ])->assertRedirect(route('home'));
    }
    /** @test **/
    public function test_user_cannot_login_with_incorrect_password()
    {
        $user = factory(User::class)->create();

        $response = $this->post(route('login'),[
            'email' => $user->email,
            'password' => 'wrong-password'
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertGuest();
    }
    /** @test **/
    public function test_user_can_view_a_login_form()
    {
        $response = $this->get('/login');
        $response->assertSuccessful();
        $response->assertViewIs('auth.login');
    }
}
