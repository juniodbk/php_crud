<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Database\Factories\ProductFactory;

class ProductIndexTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     *
     * @return void
     */
    public function it_should_return_without_products()
    {
        $response = $this->get('/products');
        $productsResponse = $response->viewData('products');
        $this::assertEquals(0, $productsResponse->count());
    }

    /**
     * @test
     *
     * @return void
     */
    public function it_should_return_with_3_products()
    {
        $productsGenerated = app(ProductFactory::class)->count(3)->make();
        foreach ($productsGenerated as $product) {
            $product->save();
        }

        $response = $this->get('/products');
        $productsResponse = $response->viewData('products');

        $this::assertEquals(3, $productsResponse->count());
    }
}
