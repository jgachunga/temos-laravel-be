<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\OutletVisit;

class OutletVisitApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_outlet_visit()
    {
        $outletVisit = factory(OutletVisit::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/outlet_visits', $outletVisit
        );

        $this->assertApiResponse($outletVisit);
    }

    /**
     * @test
     */
    public function test_read_outlet_visit()
    {
        $outletVisit = factory(OutletVisit::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/outlet_visits/'.$outletVisit->id
        );

        $this->assertApiResponse($outletVisit->toArray());
    }

    /**
     * @test
     */
    public function test_update_outlet_visit()
    {
        $outletVisit = factory(OutletVisit::class)->create();
        $editedOutletVisit = factory(OutletVisit::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/outlet_visits/'.$outletVisit->id,
            $editedOutletVisit
        );

        $this->assertApiResponse($editedOutletVisit);
    }

    /**
     * @test
     */
    public function test_delete_outlet_visit()
    {
        $outletVisit = factory(OutletVisit::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/outlet_visits/'.$outletVisit->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/outlet_visits/'.$outletVisit->id
        );

        $this->response->assertStatus(404);
    }
}
