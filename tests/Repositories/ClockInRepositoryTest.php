<?php namespace Tests\Repositories;

use App\Models\ClockIn;
use App\Repositories\Backend\ClockInRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class ClockInRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var ClockInRepository
     */
    protected $clockInRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->clockInRepo = \App::make(ClockInRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_clock_in()
    {
        $clockIn = factory(ClockIn::class)->make()->toArray();

        $createdClockIn = $this->clockInRepo->create($clockIn);

        $createdClockIn = $createdClockIn->toArray();
        $this->assertArrayHasKey('id', $createdClockIn);
        $this->assertNotNull($createdClockIn['id'], 'Created ClockIn must have id specified');
        $this->assertNotNull(ClockIn::find($createdClockIn['id']), 'ClockIn with given id must be in DB');
        $this->assertModelData($clockIn, $createdClockIn);
    }

    /**
     * @test read
     */
    public function test_read_clock_in()
    {
        $clockIn = factory(ClockIn::class)->create();

        $dbClockIn = $this->clockInRepo->find($clockIn->id);

        $dbClockIn = $dbClockIn->toArray();
        $this->assertModelData($clockIn->toArray(), $dbClockIn);
    }

    /**
     * @test update
     */
    public function test_update_clock_in()
    {
        $clockIn = factory(ClockIn::class)->create();
        $fakeClockIn = factory(ClockIn::class)->make()->toArray();

        $updatedClockIn = $this->clockInRepo->update($fakeClockIn, $clockIn->id);

        $this->assertModelData($fakeClockIn, $updatedClockIn->toArray());
        $dbClockIn = $this->clockInRepo->find($clockIn->id);
        $this->assertModelData($fakeClockIn, $dbClockIn->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_clock_in()
    {
        $clockIn = factory(ClockIn::class)->create();

        $resp = $this->clockInRepo->delete($clockIn->id);

        $this->assertTrue($resp);
        $this->assertNull(ClockIn::find($clockIn->id), 'ClockIn should not exist in DB');
    }
}
