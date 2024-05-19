<?php namespace Tests\Repositories;

use App\Models\Area;
use App\Repositories\Backend\AreaRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class AreaRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var AreaRepository
     */
    protected $areaRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->areaRepo = \App::make(AreaRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_area()
    {
        $area = factory(Area::class)->make()->toArray();

        $createdArea = $this->areaRepo->create($area);

        $createdArea = $createdArea->toArray();
        $this->assertArrayHasKey('id', $createdArea);
        $this->assertNotNull($createdArea['id'], 'Created Area must have id specified');
        $this->assertNotNull(Area::find($createdArea['id']), 'Area with given id must be in DB');
        $this->assertModelData($area, $createdArea);
    }

    /**
     * @test read
     */
    public function test_read_area()
    {
        $area = factory(Area::class)->create();

        $dbArea = $this->areaRepo->find($area->id);

        $dbArea = $dbArea->toArray();
        $this->assertModelData($area->toArray(), $dbArea);
    }

    /**
     * @test update
     */
    public function test_update_area()
    {
        $area = factory(Area::class)->create();
        $fakeArea = factory(Area::class)->make()->toArray();

        $updatedArea = $this->areaRepo->update($fakeArea, $area->id);

        $this->assertModelData($fakeArea, $updatedArea->toArray());
        $dbArea = $this->areaRepo->find($area->id);
        $this->assertModelData($fakeArea, $dbArea->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_area()
    {
        $area = factory(Area::class)->create();

        $resp = $this->areaRepo->delete($area->id);

        $this->assertTrue($resp);
        $this->assertNull(Area::find($area->id), 'Area should not exist in DB');
    }
}
