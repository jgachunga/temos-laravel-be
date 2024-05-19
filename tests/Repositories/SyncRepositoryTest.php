<?php namespace Tests\Repositories;

use App\Models\Sync;
use App\Repositories\Backend\SyncRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class SyncRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var SyncRepository
     */
    protected $syncRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->syncRepo = \App::make(SyncRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_sync()
    {
        $sync = factory(Sync::class)->make()->toArray();

        $createdSync = $this->syncRepo->create($sync);

        $createdSync = $createdSync->toArray();
        $this->assertArrayHasKey('id', $createdSync);
        $this->assertNotNull($createdSync['id'], 'Created Sync must have id specified');
        $this->assertNotNull(Sync::find($createdSync['id']), 'Sync with given id must be in DB');
        $this->assertModelData($sync, $createdSync);
    }

    /**
     * @test read
     */
    public function test_read_sync()
    {
        $sync = factory(Sync::class)->create();

        $dbSync = $this->syncRepo->find($sync->id);

        $dbSync = $dbSync->toArray();
        $this->assertModelData($sync->toArray(), $dbSync);
    }

    /**
     * @test update
     */
    public function test_update_sync()
    {
        $sync = factory(Sync::class)->create();
        $fakeSync = factory(Sync::class)->make()->toArray();

        $updatedSync = $this->syncRepo->update($fakeSync, $sync->id);

        $this->assertModelData($fakeSync, $updatedSync->toArray());
        $dbSync = $this->syncRepo->find($sync->id);
        $this->assertModelData($fakeSync, $dbSync->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_sync()
    {
        $sync = factory(Sync::class)->create();

        $resp = $this->syncRepo->delete($sync->id);

        $this->assertTrue($resp);
        $this->assertNull(Sync::find($sync->id), 'Sync should not exist in DB');
    }
}
