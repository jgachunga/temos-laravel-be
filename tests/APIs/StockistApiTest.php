<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Stockist;

class StockistApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_stockist()
    {
        $stockist = factory(Stockist::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/stockists', $stockist
        );

        $this->assertApiResponse($stockist);
    }

    /**
     * @test
     */
    public function test_read_stockist()
    {
        $stockist = factory(Stockist::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/stockists/'.$stockist->id
        );

        $this->assertApiResponse($stockist->toArray());
    }

    /**
     * @test
     */
    public function test_update_stockist()
    {
        $stockist = factory(Stockist::class)->create();
        $editedStockist = factory(Stockist::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/stockists/'.$stockist->id,
            $editedStockist
        );

        $this->assertApiResponse($editedStockist);
    }

    /**
     * @test
     */
    public function test_delete_stockist()
    {
        $stockist = factory(Stockist::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/stockists/'.$stockist->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/stockists/'.$stockist->id
        );

        $this->response->assertStatus(404);
    }
}
