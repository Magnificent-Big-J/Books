<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CustomerTest extends TestCase
{
    use RefreshDatabase;

    /** @test **/
    public function customer_can_create_an_account()
    {
        $this->withoutExceptionHandling();
        $this->post(route('register'),[
            'name' => 'Joel Mnisi',
            'email' => 'joel@mnisi.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ])->assertRedirect(route('home'));

        $this->assertDatabaseHas('users',[
            'name' => 'Joel Mnisi'
        ]);

        $this->assertTrue(User::count() > 0);

    }
    /** @test **/
    public function user_can_update_information()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);
        $response = $this->put(route('user.update', $user->id),[
            'name' => 'Joel Mnisi',
            'email' => 'joel@mnisi.com',
            'password' => 'password',
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('users',[
            'email'=>'joel@mnisi.com'
        ]);
    }
}
