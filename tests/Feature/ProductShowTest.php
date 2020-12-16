<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;
use Database\Factories\ProductFactory;

class ProductShowTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * @return void
     */
    public function it_should_return_404_for_inexistent_product()
    {
        $response = $this->get('product/show/1');
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    /**
     * @test
     * @return void
     */
    public function it_should_return_a_product_object()
    {
        $productGenerated = app(ProductFactory::class)->make();
        $productGenerated->save();

        $response = $this->get('products/'.$productGenerated->id);
        $response->assertStatus(Response::HTTP_OK);
        
        $productViewReturn = $response->viewData('product');

        $this->assertEquals($productGenerated->name, $productViewReturn->name);
        $this->assertEquals($productGenerated->description, $productViewReturn->description);
        $this->assertEquals($productGenerated->price, $productViewReturn->price);
    }
}