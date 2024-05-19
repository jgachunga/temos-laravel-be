<?php namespace Tests\Repositories;

use App\Models\CurrentStatuses;
use App\Repositories\Backend\CurrentStatusesRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class CurrentStatusesRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var CurrentStatusesRepository
     */
    protected $currentStatusesRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->currentStatusesRepo = \App::make(CurrentStatusesRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_current_statuses()
    {
        $currentStatuses = factory(CurrentStatuses::class)->make()->toArray();

        $createdCurrentStatuses = $this->currentStatusesRepo->create($currentStatuses);

        $createdCurrentStatuses = $createdCurrentStatuses->toArray();
        $this->assertArrayHasKey('id', $createdCurrentStatuses);
        $this->assertNotNull($createdCurrentStatuses['id'], 'Created CurrentStatuses must have id specified');
        $this->assertNotNull(CurrentStatuses::find($createdCurrentStatuses['id']), 'CurrentStatuses with given id must be in DB');
        $this->assertModelData($currentStatuses, $createdCurrentStatuses);
    }

    /**
     * @test read
     */
    public function test_read_current_statuses()
    {
        $currentStatuses = factory(CurrentStatuses::class)->create();

        $dbCurrentStatuses = $this->currentStatusesRepo->find($currentStatuses->id);

        $dbCurrentStatuses = $dbCurrentStatuses->toArray();
        $this->assertModelData($currentStatuses->toArray(), $dbCurrentStatuses);
    }

    /**
     * @test update
     */
    public function test_update_current_statuses()
    {
        $currentStatuses = factory(CurrentStatuses::class)->create();
        $fakeCurrentStatuses = factory(CurrentStatuses::class)->make()->toArray();

        $updatedCurrentStatuses = $this->currentStatusesRepo->update($fakeCurrentStatuses, $currentStatuses->id);

        $this->assertModelData($fakeCurrentStatuses, $updatedCurrentStatuses->toArray());
        $dbCurrentStatuses = $this->currentStatusesRepo->find($currentStatuses->id);
        $this->assertModelData($fakeCurrentStatuses, $dbCurrentStatuses->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_current_statuses()
    {
        $currentStatuses = factory(CurrentStatuses::class)->create();

        $resp = $this->currentStatusesRepo->delete($currentStatuses->id);

        $this->assertTrue($resp);
        $this->assertNull(CurrentStatuses::find($currentStatuses->id), 'CurrentStatuses should not exist in DB');
    }
}
