<?php

namespace Tests\Feature;

use App\Author;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Carbon\Carbon;

class AuthorManagementTest extends TestCase
{
    use RefreshDatabase;
    /** @test **/
    public function view_list_of_authors()
    {
        $this->authenticateAdmin();
        $author1 = factory(Author::class)->create();
        $author2 = factory(Author::class)->create();
        $response = $this->get(route('author.index'));
        $response->assertStatus(200);

        $response->assertSee($author1->name);
        $response->assertSee($author2->name);
    }
    /** @test **/
    public function can_create_author()
    {
        $this->authenticateAdmin();

        $response = $this->post(route('author.store'), $this->getData());
        $response->assertStatus(200);

        $this->assertDatabaseHas('authors',[
            'name' => $this->getData()['name']
        ]);

        $this->assertDatabaseCount('authors', 1);
    }
    /** @test **/
    public function author_name_is_required()
    {
        $this->authenticateAdmin();

        $response = $this->post(route('author.store'),
            array_merge($this->getData(), ['name'=> null]));
        $response->assertSessionHasErrors('name');
        $this->assertDatabaseCount('authors',0);
    }
    /** @test **/
    public function author_surname_is_required()
    {
        $this->authenticateAdmin();

        $response = $this->post(route('author.store'),
            array_merge($this->getData(), ['surname'=> null]));
        $response->assertSessionHasErrors('surname');

        $this->assertDatabaseCount('authors',0);
    }
    /** @test *d*/
    public function can_update_author()
    {
        $this->authenticateAdmin();
        $response = $this->post(route('author.store'), $this->getData());
        $response->assertStatus(200);

                $this->assertDatabaseHas('authors',[
                      'name' => $this->getData()['name']
                ]);

                $this->assertTrue(Author::count() > 0);
                $author = Author::find(1);

                $response = $this->put(route('author.update', $author->id),
                                    array_merge($this->getData(),[
                                        'dob' => '1989-12-21',
                                        'bibliography'=> 'On the other hand'
                                    ]));

                $response->assertStatus(200);
                $updatedAuthor = Author::find(1);
                $this->assertEquals($author->id, $updatedAuthor->id);
                $this->assertInstanceOf( Carbon::class, $updatedAuthor->dob);

    }
    /** @test **/
    public function can_delete_author()
    {
        $this->authenticateAdmin();
        $response = $this->post(route('author.store'), $this->getData());
        $response->assertStatus(200);

        $author = Author::find(1);
        $response = $this->delete(route('author.destroy', $author->id));
        $response->assertStatus(200);
        $this->assertDatabaseCount('authors', 0);
        $response->assertSessionHas('success', 'Author is successfully created.');
    }
    private function getData()
    {
        return [
            'name' => 'Joel',
            'surname' => 'Mnisi',
        ];
    }
}
