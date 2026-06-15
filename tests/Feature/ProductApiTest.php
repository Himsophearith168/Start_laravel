<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\ProductModel;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_product()
    {
        $response = $this->postJson('/api/products', [
            'name' => 'Test Product',
            'description' => 'Test Description',
            'price' => 99.99,
            'Qty' => 10,
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('products', [
            'name' => 'Test Product'
        ]);
    }

    public function test_can_get_product()
    {
        $product = ProductModel::create([
            'name' => 'Existing Product',
            'description' => 'Existing Description',
            'price' => 50.00,
            'Qty' => 5,
            'image' => 'test.jpg'
        ]);

        $response = $this->getJson('/api/products/' . $product->id);

        $response->assertStatus(200)
                 ->assertJsonPath('data.name', 'Existing Product');
    }
}
