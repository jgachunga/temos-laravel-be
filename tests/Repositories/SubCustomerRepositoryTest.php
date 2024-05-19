<?php namespace Tests\Repositories;

use App\Models\SubCustomer;
use App\Repositories\Backend\SubCustomerRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class SubCustomerRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var SubCustomerRepository
     */
    protected $subCustomerRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->subCustomerRepo = \App::make(SubCustomerRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_sub_customer()
    {
        $subCustomer = factory(SubCustomer::class)->make()->toArray();

        $createdSubCustomer = $this->subCustomerRepo->create($subCustomer);

        $createdSubCustomer = $createdSubCustomer->toArray();
        $this->assertArrayHasKey('id', $createdSubCustomer);
        $this->assertNotNull($createdSubCustomer['id'], 'Created SubCustomer must have id specified');
        $this->assertNotNull(SubCustomer::find($createdSubCustomer['id']), 'SubCustomer with given id must be in DB');
        $this->assertModelData($subCustomer, $createdSubCustomer);
    }

    /**
     * @test read
     */
    public function test_read_sub_customer()
    {
        $subCustomer = factory(SubCustomer::class)->create();

        $dbSubCustomer = $this->subCustomerRepo->find($subCustomer->id);

        $dbSubCustomer = $dbSubCustomer->toArray();
        $this->assertModelData($subCustomer->toArray(), $dbSubCustomer);
    }

    /**
     * @test update
     */
    public function test_update_sub_customer()
    {
        $subCustomer = factory(SubCustomer::class)->create();
        $fakeSubCustomer = factory(SubCustomer::class)->make()->toArray();

        $updatedSubCustomer = $this->subCustomerRepo->update($fakeSubCustomer, $subCustomer->id);

        $this->assertModelData($fakeSubCustomer, $updatedSubCustomer->toArray());
        $dbSubCustomer = $this->subCustomerRepo->find($subCustomer->id);
        $this->assertModelData($fakeSubCustomer, $dbSubCustomer->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_sub_customer()
    {
        $subCustomer = factory(SubCustomer::class)->create();

        $resp = $this->subCustomerRepo->delete($subCustomer->id);

        $this->assertTrue($resp);
        $this->assertNull(SubCustomer::find($subCustomer->id), 'SubCustomer should not exist in DB');
    }
}
