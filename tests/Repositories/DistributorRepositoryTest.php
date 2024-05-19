<?php namespace Tests\Repositories;

use App\Models\Distributor;
use App\Repositories\Backend\DistributorRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class DistributorRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var DistributorRepository
     */
    protected $distributorRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->distributorRepo = \App::make(DistributorRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_distributor()
    {
        $distributor = factory(Distributor::class)->make()->toArray();

        $createdDistributor = $this->distributorRepo->create($distributor);

        $createdDistributor = $createdDistributor->toArray();
        $this->assertArrayHasKey('id', $createdDistributor);
        $this->assertNotNull($createdDistributor['id'], 'Created Distributor must have id specified');
        $this->assertNotNull(Distributor::find($createdDistributor['id']), 'Distributor with given id must be in DB');
        $this->assertModelData($distributor, $createdDistributor);
    }

    /**
     * @test read
     */
    public function test_read_distributor()
    {
        $distributor = factory(Distributor::class)->create();

        $dbDistributor = $this->distributorRepo->find($distributor->id);

        $dbDistributor = $dbDistributor->toArray();
        $this->assertModelData($distributor->toArray(), $dbDistributor);
    }

    /**
     * @test update
     */
    public function test_update_distributor()
    {
        $distributor = factory(Distributor::class)->create();
        $fakeDistributor = factory(Distributor::class)->make()->toArray();

        $updatedDistributor = $this->distributorRepo->update($fakeDistributor, $distributor->id);

        $this->assertModelData($fakeDistributor, $updatedDistributor->toArray());
        $dbDistributor = $this->distributorRepo->find($distributor->id);
        $this->assertModelData($fakeDistributor, $dbDistributor->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_distributor()
    {
        $distributor = factory(Distributor::class)->create();

        $resp = $this->distributorRepo->delete($distributor->id);

        $this->assertTrue($resp);
        $this->assertNull(Distributor::find($distributor->id), 'Distributor should not exist in DB');
    }
}
