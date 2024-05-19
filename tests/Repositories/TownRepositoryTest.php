<?php namespace Tests\Repositories;

use App\Models\Town;
use App\Repositories\Backend\TownRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class TownRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var TownRepository
     */
    protected $townRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->townRepo = \App::make(TownRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_town()
    {
        $town = factory(Town::class)->make()->toArray();

        $createdTown = $this->townRepo->create($town);

        $createdTown = $createdTown->toArray();
        $this->assertArrayHasKey('id', $createdTown);
        $this->assertNotNull($createdTown['id'], 'Created Town must have id specified');
        $this->assertNotNull(Town::find($createdTown['id']), 'Town with given id must be in DB');
        $this->assertModelData($town, $createdTown);
    }

    /**
     * @test read
     */
    public function test_read_town()
    {
        $town = factory(Town::class)->create();

        $dbTown = $this->townRepo->find($town->id);

        $dbTown = $dbTown->toArray();
        $this->assertModelData($town->toArray(), $dbTown);
    }

    /**
     * @test update
     */
    public function test_update_town()
    {
        $town = factory(Town::class)->create();
        $fakeTown = factory(Town::class)->make()->toArray();

        $updatedTown = $this->townRepo->update($fakeTown, $town->id);

        $this->assertModelData($fakeTown, $updatedTown->toArray());
        $dbTown = $this->townRepo->find($town->id);
        $this->assertModelData($fakeTown, $dbTown->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_town()
    {
        $town = factory(Town::class)->create();

        $resp = $this->townRepo->delete($town->id);

        $this->assertTrue($resp);
        $this->assertNull(Town::find($town->id), 'Town should not exist in DB');
    }
}
