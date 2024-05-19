<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\CustomerSaleStructrure;

class CustomerSaleStructrureApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_customer_sale_structrure()
    {
        $customerSaleStructrure = factory(CustomerSaleStructrure::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/customer_sale_structrures', $customerSaleStructrure
        );

        $this->assertApiResponse($customerSaleStructrure);
    }

    /**
     * @test
     */
    public function test_read_customer_sale_structrure()
    {
        $customerSaleStructrure = factory(CustomerSaleStructrure::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/customer_sale_structrures/'.$customerSaleStructrure->id
        );

        $this->assertApiResponse($customerSaleStructrure->toArray());
    }

    /**
     * @test
     */
    public function test_update_customer_sale_structrure()
    {
        $customerSaleStructrure = factory(CustomerSaleStructrure::class)->create();
        $editedCustomerSaleStructrure = factory(CustomerSaleStructrure::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/customer_sale_structrures/'.$customerSaleStructrure->id,
            $editedCustomerSaleStructrure
        );

        $this->assertApiResponse($editedCustomerSaleStructrure);
    }

    /**
     * @test
     */
    public function test_delete_customer_sale_structrure()
    {
        $customerSaleStructrure = factory(CustomerSaleStructrure::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/customer_sale_structrures/'.$customerSaleStructrure->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/customer_sale_structrures/'.$customerSaleStructrure->id
        );

        $this->response->assertStatus(404);
    }
}
