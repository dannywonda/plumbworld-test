<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_products()
    {
        Product::factory()->count(5)->create();

        $response = $this->getJson(route('products.index'));

        $response->assertStatus(200)
                 ->assertJsonStructure(['data', 'links', 'meta']);
    }

    public function test_can_create_product()
    {
        $data = [
            'name' => 'Test Product',
            'price' => 120.00,
            'stock' => 15,
            'is_active' => true,
        ];

        $response = $this->postJson(route('products.store'), $data);

        $response->assertStatus(201)
                 ->assertJsonFragment(['name' => 'Test Product']);

        $this->assertDatabaseHas('products', ['name' => 'Test Product']);
    }

    public function test_validation_error_on_create()
    {
        $response = $this->postJson(route('products.store'), []);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['name', 'price', 'stock']);
    }

    public function test_can_show_product()
    {
        $product = Product::factory()->create();

        $response = $this->getJson(route('products.show', $product));

        $response->assertStatus(200)
                 ->assertJsonFragment(['id' => $product->id]);
    }

    public function test_can_update_product()
    {
        $product = Product::factory()->create();

        $update = ['name' => 'Updated Name'];

        $response = $this->putJson(route('products.update', $product), $update);

        $response->assertStatus(200)
                 ->assertJsonFragment(['name' => 'Updated Name']);

        $this->assertDatabaseHas('products', ['name' => 'Updated Name']);
    }

    public function test_can_delete_product()
    {
        $product = Product::factory()->create();

        $response = $this->deleteJson(route('products.destroy', $product));

        $response->assertStatus(204);

        $this->assertSoftDeleted('products', ['id' => $product->id]);
    }

    public function test_can_get_product_stats()
    {
        Product::factory()->create(['is_active' => true, 'price' => 100]);
        Product::factory()->create(['is_active' => false, 'price' => 300]);

        $response = $this->getJson(route('products.stats'));

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'total_products',
                     'active_products',
                     'inactive_products',
                     'average_price'
                 ]);
    }
}
