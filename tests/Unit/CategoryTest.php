<?php

namespace Tests\Unit;

use App\Category;
use App\User;
use Tests\TestCase;
//use PHPUnit\Framework\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;
    /** @test **/
    public function categories_are_created()
    {
        $category = factory(Category::class)->create();
        $this->assertCount(1, Category::all());
        $this->assertDatabaseHas('categories',[
            'name'=> $category->name
        ]);
    }
}
