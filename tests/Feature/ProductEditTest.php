<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Database\Factories\ProductFactory;
use Illuminate\Http\Response;

class ProductEditTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * @return void
     */
    public function it_should_return_404_for_inexistent_product()
    {
        $response = $this->get('products/1/edit');
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    /**
     * @test
     * @return void
     */
    public function it_should_edit_a_product()
    {
        $productGenerated = app(ProductFactory::class)->make();
        $productGenerated->save();

        $response = $this->get('products/'.$productGenerated->id.'/edit');
        $response->assertStatus(Response::HTTP_OK);
        
        $productViewReturn = $response->viewData('product');
        
        $productViewReturn->name = 'jamal';

        $response = $this->put('products/'.$productViewReturn->id, $productViewReturn->getAttributes());
        $response->assertStatus(302);
        $message = $response->getSession()->get('success');

        $this->assertEquals($message, 'Product updated successfully');

        $productUpdated = $this->get('products/'.$productGenerated->id)->viewData('product');

        $this->assertEquals('jamal', $productUpdated->name);
        $this->assertEquals($productGenerated->description, $productUpdated->description);
        $this->assertEquals($productGenerated->price, $productUpdated->price);
    }
}