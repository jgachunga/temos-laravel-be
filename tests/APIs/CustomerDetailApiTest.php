<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\CustomerDetail;

class CustomerDetailApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_customer_detail()
    {
        $customerDetail = factory(CustomerDetail::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/customer_details', $customerDetail
        );

        $this->assertApiResponse($customerDetail);
    }

    /**
     * @test
     */
    public function test_read_customer_detail()
    {
        $customerDetail = factory(CustomerDetail::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/customer_details/'.$customerDetail->id
        );

        $this->assertApiResponse($customerDetail->toArray());
    }

    /**
     * @test
     */
    public function test_update_customer_detail()
    {
        $customerDetail = factory(CustomerDetail::class)->create();
        $editedCustomerDetail = factory(CustomerDetail::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/customer_details/'.$customerDetail->id,
            $editedCustomerDetail
        );

        $this->assertApiResponse($editedCustomerDetail);
    }

    /**
     * @test
     */
    public function test_delete_customer_detail()
    {
        $customerDetail = factory(CustomerDetail::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/customer_details/'.$customerDetail->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/customer_details/'.$customerDetail->id
        );

        $this->response->assertStatus(404);
    }
}
