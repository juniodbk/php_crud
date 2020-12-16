<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Database\Factories\ProductFactory;
use Illuminate\Http\Response;

class ProductDeleteTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * @test
     * @return void
     */
    public function it_should_delete_a_product()
    {
        $productGenerated = app(ProductFactory::class)->make();
        $productGenerated->save();
        
        $response = $this->delete('/products/'.$productGenerated->id);
        $message = $response->getSession()->get('success');
        $products = $this->get('/products')->viewData('products');;
        
        $response->assertStatus(Response::HTTP_FOUND);
        $this->assertEquals($message, 'Product deleted successfully');
        $this->assertEquals(0, $products->count());
    }
}
