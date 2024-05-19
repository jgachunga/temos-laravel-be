<?php namespace Tests\Repositories;

use App\Models\SalesRep;
use App\Repositories\Backend\SalesRepRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class SalesRepRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var SalesRepRepository
     */
    protected $salesRepRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->salesRepRepo = \App::make(SalesRepRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_sales_rep()
    {
        $salesRep = factory(SalesRep::class)->make()->toArray();

        $createdSalesRep = $this->salesRepRepo->create($salesRep);

        $createdSalesRep = $createdSalesRep->toArray();
        $this->assertArrayHasKey('id', $createdSalesRep);
        $this->assertNotNull($createdSalesRep['id'], 'Created SalesRep must have id specified');
        $this->assertNotNull(SalesRep::find($createdSalesRep['id']), 'SalesRep with given id must be in DB');
        $this->assertModelData($salesRep, $createdSalesRep);
    }

    /**
     * @test read
     */
    public function test_read_sales_rep()
    {
        $salesRep = factory(SalesRep::class)->create();

        $dbSalesRep = $this->salesRepRepo->find($salesRep->id);

        $dbSalesRep = $dbSalesRep->toArray();
        $this->assertModelData($salesRep->toArray(), $dbSalesRep);
    }

    /**
     * @test update
     */
    public function test_update_sales_rep()
    {
        $salesRep = factory(SalesRep::class)->create();
        $fakeSalesRep = factory(SalesRep::class)->make()->toArray();

        $updatedSalesRep = $this->salesRepRepo->update($fakeSalesRep, $salesRep->id);

        $this->assertModelData($fakeSalesRep, $updatedSalesRep->toArray());
        $dbSalesRep = $this->salesRepRepo->find($salesRep->id);
        $this->assertModelData($fakeSalesRep, $dbSalesRep->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_sales_rep()
    {
        $salesRep = factory(SalesRep::class)->create();

        $resp = $this->salesRepRepo->delete($salesRep->id);

        $this->assertTrue($resp);
        $this->assertNull(SalesRep::find($salesRep->id), 'SalesRep should not exist in DB');
    }
}
