<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\SalesRep;

class SalesRepApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_sales_rep()
    {
        $salesRep = factory(SalesRep::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/sales_reps', $salesRep
        );

        $this->assertApiResponse($salesRep);
    }

    /**
     * @test
     */
    public function test_read_sales_rep()
    {
        $salesRep = factory(SalesRep::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/sales_reps/'.$salesRep->id
        );

        $this->assertApiResponse($salesRep->toArray());
    }

    /**
     * @test
     */
    public function test_update_sales_rep()
    {
        $salesRep = factory(SalesRep::class)->create();
        $editedSalesRep = factory(SalesRep::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/sales_reps/'.$salesRep->id,
            $editedSalesRep
        );

        $this->assertApiResponse($editedSalesRep);
    }

    /**
     * @test
     */
    public function test_delete_sales_rep()
    {
        $salesRep = factory(SalesRep::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/sales_reps/'.$salesRep->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/sales_reps/'.$salesRep->id
        );

        $this->response->assertStatus(404);
    }
}
