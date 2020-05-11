<?php

namespace Tests\Feature;

use App\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookCategoryTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function can_create_category()
    {
        $this->authenticateAdmin();
        $response = $this->post(route('category.store'),[
            'name' => 'Action and Adventure'
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('categories',[
            'name' => 'Action and Adventure'
        ]);
        $response->assertSessionHas('success','Category is successfully created.');
    }
    /** @test **/
    public function name_is_required()
    {
        $this->authenticateAdmin();
        $response = $this->post(route('category.store'),[
            'name' => null
        ]);
        $response->assertSessionHasErrors('name');
        $this->assertCount(0, Category::all());
    }
}
