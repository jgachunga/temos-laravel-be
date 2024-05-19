<?php namespace Tests\Repositories;

use App\Models\CustomerSaleStructrure;
use App\Repositories\Backend\CustomerSaleStructrureRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class CustomerSaleStructrureRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var CustomerSaleStructrureRepository
     */
    protected $customerSaleStructrureRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->customerSaleStructrureRepo = \App::make(CustomerSaleStructrureRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_customer_sale_structrure()
    {
        $customerSaleStructrure = factory(CustomerSaleStructrure::class)->make()->toArray();

        $createdCustomerSaleStructrure = $this->customerSaleStructrureRepo->create($customerSaleStructrure);

        $createdCustomerSaleStructrure = $createdCustomerSaleStructrure->toArray();
        $this->assertArrayHasKey('id', $createdCustomerSaleStructrure);
        $this->assertNotNull($createdCustomerSaleStructrure['id'], 'Created CustomerSaleStructrure must have id specified');
        $this->assertNotNull(CustomerSaleStructrure::find($createdCustomerSaleStructrure['id']), 'CustomerSaleStructrure with given id must be in DB');
        $this->assertModelData($customerSaleStructrure, $createdCustomerSaleStructrure);
    }

    /**
     * @test read
     */
    public function test_read_customer_sale_structrure()
    {
        $customerSaleStructrure = factory(CustomerSaleStructrure::class)->create();

        $dbCustomerSaleStructrure = $this->customerSaleStructrureRepo->find($customerSaleStructrure->id);

        $dbCustomerSaleStructrure = $dbCustomerSaleStructrure->toArray();
        $this->assertModelData($customerSaleStructrure->toArray(), $dbCustomerSaleStructrure);
    }

    /**
     * @test update
     */
    public function test_update_customer_sale_structrure()
    {
        $customerSaleStructrure = factory(CustomerSaleStructrure::class)->create();
        $fakeCustomerSaleStructrure = factory(CustomerSaleStructrure::class)->make()->toArray();

        $updatedCustomerSaleStructrure = $this->customerSaleStructrureRepo->update($fakeCustomerSaleStructrure, $customerSaleStructrure->id);

        $this->assertModelData($fakeCustomerSaleStructrure, $updatedCustomerSaleStructrure->toArray());
        $dbCustomerSaleStructrure = $this->customerSaleStructrureRepo->find($customerSaleStructrure->id);
        $this->assertModelData($fakeCustomerSaleStructrure, $dbCustomerSaleStructrure->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_customer_sale_structrure()
    {
        $customerSaleStructrure = factory(CustomerSaleStructrure::class)->create();

        $resp = $this->customerSaleStructrureRepo->delete($customerSaleStructrure->id);

        $this->assertTrue($resp);
        $this->assertNull(CustomerSaleStructrure::find($customerSaleStructrure->id), 'CustomerSaleStructrure should not exist in DB');
    }
}
