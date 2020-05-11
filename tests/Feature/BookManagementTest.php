<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookManagementTest extends TestCase
{
    use RefreshDatabase;
   /** @test **/
    public function can_create_a_book()
    {
        $this->authenticateAdmin();
        $response = $this->post(route('book.store'), $this->getData());
        $response->assertStatus(200);
        $this->assertDatabaseCount('books', Book::all());
    }
    private function getData()
    {
        return [

        ];
    }
}
