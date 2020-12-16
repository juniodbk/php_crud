<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Database\Factories\ProductFactory;
use Illuminate\Http\Response;

class ProductCreateTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * @test
     * @return void
     */
    public function it_should_create_a_product()
    {
        $productGenerated = app(ProductFactory::class)->make();
        
        $response = $this->post('products/', $productGenerated->getAttributes());
        $response->assertStatus(Response::HTTP_FOUND);
        
        $message = $response->getSession()->get('success');
        
        $this->assertEquals($message, 'Product created successfully.');

        $productCreated = $this->get('/products')
            ->viewData('products')
            ->first();

        $this->assertEquals($productGenerated->name, $productCreated->name);
        $this->assertEquals($productGenerated->description, $productCreated->description);
        $this->assertEquals($productGenerated->price, $productCreated->price);
    }
}
