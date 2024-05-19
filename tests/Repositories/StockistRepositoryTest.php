<?php namespace Tests\Repositories;

use App\Models\Stockist;
use App\Repositories\Backend\StockistRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class StockistRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var StockistRepository
     */
    protected $stockistRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->stockistRepo = \App::make(StockistRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_stockist()
    {
        $stockist = factory(Stockist::class)->make()->toArray();

        $createdStockist = $this->stockistRepo->create($stockist);

        $createdStockist = $createdStockist->toArray();
        $this->assertArrayHasKey('id', $createdStockist);
        $this->assertNotNull($createdStockist['id'], 'Created Stockist must have id specified');
        $this->assertNotNull(Stockist::find($createdStockist['id']), 'Stockist with given id must be in DB');
        $this->assertModelData($stockist, $createdStockist);
    }

    /**
     * @test read
     */
    public function test_read_stockist()
    {
        $stockist = factory(Stockist::class)->create();

        $dbStockist = $this->stockistRepo->find($stockist->id);

        $dbStockist = $dbStockist->toArray();
        $this->assertModelData($stockist->toArray(), $dbStockist);
    }

    /**
     * @test update
     */
    public function test_update_stockist()
    {
        $stockist = factory(Stockist::class)->create();
        $fakeStockist = factory(Stockist::class)->make()->toArray();

        $updatedStockist = $this->stockistRepo->update($fakeStockist, $stockist->id);

        $this->assertModelData($fakeStockist, $updatedStockist->toArray());
        $dbStockist = $this->stockistRepo->find($stockist->id);
        $this->assertModelData($fakeStockist, $dbStockist->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_stockist()
    {
        $stockist = factory(Stockist::class)->create();

        $resp = $this->stockistRepo->delete($stockist->id);

        $this->assertTrue($resp);
        $this->assertNull(Stockist::find($stockist->id), 'Stockist should not exist in DB');
    }
}
