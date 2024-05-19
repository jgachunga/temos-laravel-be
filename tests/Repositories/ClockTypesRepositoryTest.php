<?php namespace Tests\Repositories;

use App\Models\ClockTypes;
use App\Repositories\Backend\ClockTypesRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class ClockTypesRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var ClockTypesRepository
     */
    protected $clockTypesRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->clockTypesRepo = \App::make(ClockTypesRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_clock_types()
    {
        $clockTypes = factory(ClockTypes::class)->make()->toArray();

        $createdClockTypes = $this->clockTypesRepo->create($clockTypes);

        $createdClockTypes = $createdClockTypes->toArray();
        $this->assertArrayHasKey('id', $createdClockTypes);
        $this->assertNotNull($createdClockTypes['id'], 'Created ClockTypes must have id specified');
        $this->assertNotNull(ClockTypes::find($createdClockTypes['id']), 'ClockTypes with given id must be in DB');
        $this->assertModelData($clockTypes, $createdClockTypes);
    }

    /**
     * @test read
     */
    public function test_read_clock_types()
    {
        $clockTypes = factory(ClockTypes::class)->create();

        $dbClockTypes = $this->clockTypesRepo->find($clockTypes->id);

        $dbClockTypes = $dbClockTypes->toArray();
        $this->assertModelData($clockTypes->toArray(), $dbClockTypes);
    }

    /**
     * @test update
     */
    public function test_update_clock_types()
    {
        $clockTypes = factory(ClockTypes::class)->create();
        $fakeClockTypes = factory(ClockTypes::class)->make()->toArray();

        $updatedClockTypes = $this->clockTypesRepo->update($fakeClockTypes, $clockTypes->id);

        $this->assertModelData($fakeClockTypes, $updatedClockTypes->toArray());
        $dbClockTypes = $this->clockTypesRepo->find($clockTypes->id);
        $this->assertModelData($fakeClockTypes, $dbClockTypes->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_clock_types()
    {
        $clockTypes = factory(ClockTypes::class)->create();

        $resp = $this->clockTypesRepo->delete($clockTypes->id);

        $this->assertTrue($resp);
        $this->assertNull(ClockTypes::find($clockTypes->id), 'ClockTypes should not exist in DB');
    }
}
