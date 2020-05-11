<?php

namespace Tests\Feature;

use App\Publisher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublisherTest extends TestCase
{
    use RefreshDatabase;
    /** @test **/
    public function admin_can_create_publisher()
    {
        $this->authenticateAdmin();
        $response = $this->post(route('publisher.store'), [
            'name' => 'Pearson'
        ]);
        $response->assertStatus(200);
        $this->assertDatabaseHas('publishers',[
           'name' => 'Pearson'
        ]);
        $this->assertCount(1, Publisher::all());
        $response->assertSessionHas('success', 'Publisher is successfully created.');
    }
    /** @test */
    public function publisher_name_is_required()
    {
        $this->authenticateAdmin();
        $response = $this->post(route('publisher.store'), [
            'name' => null
        ]);

        $response->assertSessionHasErrors('name');
        $this->assertCount(0, Publisher::all());
    }
    /** @test **/
    public function can_view_publisher()
    {
        $this->authenticateAdmin();
        $publisher = factory(Publisher::class)->create();
        $response = $this->get(route('publisher.show', $publisher->id));
        $response->assertSuccessful();
        $response->assertViewIs('admin.publisher.show');
        $response->assertSee($publisher->name);
    }
    /** @test  **/
    public function can_update_publisher()
    {
        $this->withoutExceptionHandling();
        $this->authenticateAdmin();
        $response = $this->post(route('publisher.store'), [
            'name' => 'Pearson'
        ]);
        $response->assertStatus(200);
        $this->assertDatabaseHas('publishers',[
            'name' => 'Pearson'
        ]);
        $publisher = Publisher::find(1);
        $response = $this->put(route('publisher.update', $publisher->id) , [
            'name' => 'Freedom Stationery'
        ]);
        $response->assertStatus(200);
        $this->assertDatabaseHas('publishers',[
            'name' => 'Freedom Stationery'
        ]);
        $this->assertCount(1, Publisher::all());
        $response->assertSessionHas('success', 'Publisher is successfully updated.');
    }

}
