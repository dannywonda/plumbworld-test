<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Product;
use App\Repositories\ProductRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private ProductRepository $repository;

    protected function createProduct()
    {
        return Product::factory()->create();
    }


    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new ProductRepository(app());
    }

    public function test_create_product()
    {
        $data = [
            'name' => 'Test Product',
            'price' => 100.0,
            'stock' => 50,
            'is_active' => true,
            'slug' => 'test-product',
            'published_at' => now(),
        ];

        $product = $this->repository->create($data);

        $this->assertInstanceOf(Product::class, $product);
        $this->assertDatabaseHas('products', ['name' => 'Test Product']);
    }

    public function test_update_product()
    {
        $product = $this->createProduct();

        $updateData = ['name' => 'New Name'];

        $updatedProduct = $this->repository->update($updateData, $product);

        $this->assertEquals('New Name', $updatedProduct->name);
        $this->assertDatabaseHas('products', ['name' => 'New Name']);
    }

    public function test_delete_product()
    {
        $product = $this->createProduct();

        $this->assertDatabaseHas('products', ['id' => $product->id]);
        $countBefore = Product::count();

        $result = $this->repository->delete($product);

        $this->assertTrue($result);
        
        $this->assertSoftDeleted('products', ['id' => $product->id]);

        $this->assertEquals($countBefore - 1, Product::count());
    }

    public function test_stats_method_returns_correct_data()
    {
        Product::factory()->count(3)->create(['is_active' => true, 'price' => 100]);
        Product::factory()->count(2)->create(['is_active' => false, 'price' => 50]);

        $stats = $this->repository->stats();

        $this->assertEquals(5, $stats['total_products']);
        $this->assertEquals(3, $stats['active_products']);
        $this->assertEquals(2, $stats['inactive_products']);
        $this->assertEqualsWithDelta(80, $stats['average_price'], 0.01);
    }

    public function test_all_method_with_filters()
    {
        Product::factory()->create(['name' => 'Apple',  'slug' => 'atest-product', 'price' => 100, 'stock' => 10, 'is_active' => true]);
        Product::factory()->create(['name' => 'Banana', 'slug' => 'btest-product', 'price' => 50, 'stock' => 5, 'is_active' => false]);
        Product::factory()->create(['name' => 'Cherry', 'slug' => 'ctest-product', 'price' => 75, 'stock' => 20, 'is_active' => true]);

        $request = new \Illuminate\Http\Request();
        $request->merge(['name' => 'apple']);

        $results = $this->repository->all($request);

        $this->assertCount(2, $results);
        $this->assertTrue($results->first()->name === 'Apple' || $results->first()->name === 'Cherry');
    }
}
