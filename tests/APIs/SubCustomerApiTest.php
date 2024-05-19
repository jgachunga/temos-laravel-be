<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\SubCustomer;

class SubCustomerApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_sub_customer()
    {
        $subCustomer = factory(SubCustomer::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/sub_customers', $subCustomer
        );

        $this->assertApiResponse($subCustomer);
    }

    /**
     * @test
     */
    public function test_read_sub_customer()
    {
        $subCustomer = factory(SubCustomer::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/sub_customers/'.$subCustomer->id
        );

        $this->assertApiResponse($subCustomer->toArray());
    }

    /**
     * @test
     */
    public function test_update_sub_customer()
    {
        $subCustomer = factory(SubCustomer::class)->create();
        $editedSubCustomer = factory(SubCustomer::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/sub_customers/'.$subCustomer->id,
            $editedSubCustomer
        );

        $this->assertApiResponse($editedSubCustomer);
    }

    /**
     * @test
     */
    public function test_delete_sub_customer()
    {
        $subCustomer = factory(SubCustomer::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/sub_customers/'.$subCustomer->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/sub_customers/'.$subCustomer->id
        );

        $this->response->assertStatus(404);
    }
}
