<?php

namespace Tests\Feature;

use App\Author;
use App\Book;
use App\Category;
use App\Publisher;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Faker\Factory;

class BookManagementTest extends TestCase
{
    use RefreshDatabase;
   /** @test **/
    public function can_create_a_book()
    {
        $this->authenticateAdmin();
        $response = $this->post(route('book.store'), $this->getData());
        $response->assertStatus(200);
        $response->assertSessionHas('success', 'Book is successfully created.');
        $this->assertDatabaseCount('books', Book::count());
    }
    /** @test **/
    public function can_update_book_info()
    {
        $this->authenticateAdmin();

        $book = \factory(Book::class)->create();

        $response = $this->put(route('book.update', $book->id),
            array_merge($this->getData(),['title' => 'How to get away with murder']));
        $response->assertStatus(200);
        $response->assertSessionHas('success', 'Book is successfully updated.');
        $this->assertDatabaseHas('books', [
            'title' => 'How to get away with murder'
        ]);
        $book = Book::find(1);
        $this->assertInstanceOf(Carbon::class, $book->pub_date);

    }
    /** @test **/
    public function can_delete_book_info()
    {
        $this->authenticateAdmin();

        $book = \factory(Book::class)->create();

        $response = $this->delete(route('book.destroy', $book->id));
        $response->assertStatus(200);
        $response->assertSessionHas('success', 'Book is successfully deleted.');
        $this->assertDatabaseCount('books', 0);
    }
    /** @test **/
    public function book_title_is_required()
    {
        $this->authenticateAdmin();
        $response = $this->post(route('book.store'),
            array_merge($this->getData(), ['title'=> null]));
        $response->assertSessionHasErrors('title');
        $this->assertDatabaseCount('books', 0);
    }
    /** @test **/
    public function book_isbn_is_required()
    {
        $this->authenticateAdmin();
        $response = $this->post(route('book.store'),
            array_merge($this->getData(), ['isbn'=> null]));
        $response->assertSessionHasErrors('isbn');
        $this->assertDatabaseCount('books', 0);
    }
    /** @test **/
    public function book_pub_date_is_required()
    {
        $this->authenticateAdmin();
        $response = $this->post(route('book.store'),
            array_merge($this->getData(), ['pub_date'=> null]));
        $response->assertSessionHasErrors('pub_date');
        $this->assertDatabaseCount('books', 0);
    }
    /** @test **/
    public function book_pub_id_is_required()
    {
        $this->authenticateAdmin();
        $response = $this->post(route('book.store'),
            array_merge($this->getData(), ['pub_id'=> null]));
        $response->assertSessionHasErrors('pub_id');
        $this->assertDatabaseCount('books', 0);
    }
    /** @test **/
    public function book_author_id_is_required()
    {
        $this->authenticateAdmin();
        $response = $this->post(route('book.store'),
            array_merge($this->getData(), ['author_id'=> null]));
        $response->assertSessionHasErrors('author_id');
        $this->assertDatabaseCount('books', 0);
    }
    /** @test **/
    public function book_category_id_is_required()
    {
        $this->authenticateAdmin();
        $response = $this->post(route('book.store'),
            array_merge($this->getData(), ['category_id'=> null]));
        $response->assertSessionHasErrors('category_id');
        $this->assertDatabaseCount('books', 0);
    }
    /** @test **/
    public function book_price_is_required()
    {
        $this->authenticateAdmin();
        $response = $this->post(route('book.store'),
            array_merge($this->getData(), ['price'=> null]));
        $response->assertSessionHasErrors('price');
        $this->assertDatabaseCount('books', 0);
    }
    private function getData()
    {
        $faker = Factory::create();
        $pub_id = factory(Publisher::class)->create();
        $category = factory(Category::class)->create();
        $author = factory(Author::class)->create();
        return [
            'isbn' => $faker->isbn10,
            'title' => $faker->paragraph,
            'pub_date' => date('Y-m-d'),
            'pub_id'    => $pub_id->id,
            'author_id' => $author->id,
            'category_id' => $category->id,
            'price' => rand(100, 1000)
        ];
    }
}
