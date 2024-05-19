<?php namespace Tests\Repositories;

use App\Models\OutletVisit;
use App\Repositories\Backend\OutletVisitRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class OutletVisitRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var OutletVisitRepository
     */
    protected $outletVisitRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->outletVisitRepo = \App::make(OutletVisitRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_outlet_visit()
    {
        $outletVisit = factory(OutletVisit::class)->make()->toArray();

        $createdOutletVisit = $this->outletVisitRepo->create($outletVisit);

        $createdOutletVisit = $createdOutletVisit->toArray();
        $this->assertArrayHasKey('id', $createdOutletVisit);
        $this->assertNotNull($createdOutletVisit['id'], 'Created OutletVisit must have id specified');
        $this->assertNotNull(OutletVisit::find($createdOutletVisit['id']), 'OutletVisit with given id must be in DB');
        $this->assertModelData($outletVisit, $createdOutletVisit);
    }

    /**
     * @test read
     */
    public function test_read_outlet_visit()
    {
        $outletVisit = factory(OutletVisit::class)->create();

        $dbOutletVisit = $this->outletVisitRepo->find($outletVisit->id);

        $dbOutletVisit = $dbOutletVisit->toArray();
        $this->assertModelData($outletVisit->toArray(), $dbOutletVisit);
    }

    /**
     * @test update
     */
    public function test_update_outlet_visit()
    {
        $outletVisit = factory(OutletVisit::class)->create();
        $fakeOutletVisit = factory(OutletVisit::class)->make()->toArray();

        $updatedOutletVisit = $this->outletVisitRepo->update($fakeOutletVisit, $outletVisit->id);

        $this->assertModelData($fakeOutletVisit, $updatedOutletVisit->toArray());
        $dbOutletVisit = $this->outletVisitRepo->find($outletVisit->id);
        $this->assertModelData($fakeOutletVisit, $dbOutletVisit->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_outlet_visit()
    {
        $outletVisit = factory(OutletVisit::class)->create();

        $resp = $this->outletVisitRepo->delete($outletVisit->id);

        $this->assertTrue($resp);
        $this->assertNull(OutletVisit::find($outletVisit->id), 'OutletVisit should not exist in DB');
    }
}
