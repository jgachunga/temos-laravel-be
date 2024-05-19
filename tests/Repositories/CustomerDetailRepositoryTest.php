<?php namespace Tests\Repositories;

use App\Models\CustomerDetail;
use App\Repositories\Backend\CustomerDetailRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class CustomerDetailRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var CustomerDetailRepository
     */
    protected $customerDetailRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->customerDetailRepo = \App::make(CustomerDetailRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_customer_detail()
    {
        $customerDetail = factory(CustomerDetail::class)->make()->toArray();

        $createdCustomerDetail = $this->customerDetailRepo->create($customerDetail);

        $createdCustomerDetail = $createdCustomerDetail->toArray();
        $this->assertArrayHasKey('id', $createdCustomerDetail);
        $this->assertNotNull($createdCustomerDetail['id'], 'Created CustomerDetail must have id specified');
        $this->assertNotNull(CustomerDetail::find($createdCustomerDetail['id']), 'CustomerDetail with given id must be in DB');
        $this->assertModelData($customerDetail, $createdCustomerDetail);
    }

    /**
     * @test read
     */
    public function test_read_customer_detail()
    {
        $customerDetail = factory(CustomerDetail::class)->create();

        $dbCustomerDetail = $this->customerDetailRepo->find($customerDetail->id);

        $dbCustomerDetail = $dbCustomerDetail->toArray();
        $this->assertModelData($customerDetail->toArray(), $dbCustomerDetail);
    }

    /**
     * @test update
     */
    public function test_update_customer_detail()
    {
        $customerDetail = factory(CustomerDetail::class)->create();
        $fakeCustomerDetail = factory(CustomerDetail::class)->make()->toArray();

        $updatedCustomerDetail = $this->customerDetailRepo->update($fakeCustomerDetail, $customerDetail->id);

        $this->assertModelData($fakeCustomerDetail, $updatedCustomerDetail->toArray());
        $dbCustomerDetail = $this->customerDetailRepo->find($customerDetail->id);
        $this->assertModelData($fakeCustomerDetail, $dbCustomerDetail->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_customer_detail()
    {
        $customerDetail = factory(CustomerDetail::class)->create();

        $resp = $this->customerDetailRepo->delete($customerDetail->id);

        $this->assertTrue($resp);
        $this->assertNull(CustomerDetail::find($customerDetail->id), 'CustomerDetail should not exist in DB');
    }
}
