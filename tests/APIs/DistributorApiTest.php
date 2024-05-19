<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Distributor;

class DistributorApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_distributor()
    {
        $distributor = factory(Distributor::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/distributors', $distributor
        );

        $this->assertApiResponse($distributor);
    }

    /**
     * @test
     */
    public function test_read_distributor()
    {
        $distributor = factory(Distributor::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/distributors/'.$distributor->id
        );

        $this->assertApiResponse($distributor->toArray());
    }

    /**
     * @test
     */
    public function test_update_distributor()
    {
        $distributor = factory(Distributor::class)->create();
        $editedDistributor = factory(Distributor::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/distributors/'.$distributor->id,
            $editedDistributor
        );

        $this->assertApiResponse($editedDistributor);
    }

    /**
     * @test
     */
    public function test_delete_distributor()
    {
        $distributor = factory(Distributor::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/distributors/'.$distributor->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/distributors/'.$distributor->id
        );

        $this->response->assertStatus(404);
    }
}
