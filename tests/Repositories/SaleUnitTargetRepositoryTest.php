<?php namespace Tests\Repositories;

use App\Models\SaleUnitTarget;
use App\Repositories\Backend\SaleUnitTargetRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class SaleUnitTargetRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var SaleUnitTargetRepository
     */
    protected $saleUnitTargetRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->saleUnitTargetRepo = \App::make(SaleUnitTargetRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_sale_unit_target()
    {
        $saleUnitTarget = factory(SaleUnitTarget::class)->make()->toArray();

        $createdSaleUnitTarget = $this->saleUnitTargetRepo->create($saleUnitTarget);

        $createdSaleUnitTarget = $createdSaleUnitTarget->toArray();
        $this->assertArrayHasKey('id', $createdSaleUnitTarget);
        $this->assertNotNull($createdSaleUnitTarget['id'], 'Created SaleUnitTarget must have id specified');
        $this->assertNotNull(SaleUnitTarget::find($createdSaleUnitTarget['id']), 'SaleUnitTarget with given id must be in DB');
        $this->assertModelData($saleUnitTarget, $createdSaleUnitTarget);
    }

    /**
     * @test read
     */
    public function test_read_sale_unit_target()
    {
        $saleUnitTarget = factory(SaleUnitTarget::class)->create();

        $dbSaleUnitTarget = $this->saleUnitTargetRepo->find($saleUnitTarget->id);

        $dbSaleUnitTarget = $dbSaleUnitTarget->toArray();
        $this->assertModelData($saleUnitTarget->toArray(), $dbSaleUnitTarget);
    }

    /**
     * @test update
     */
    public function test_update_sale_unit_target()
    {
        $saleUnitTarget = factory(SaleUnitTarget::class)->create();
        $fakeSaleUnitTarget = factory(SaleUnitTarget::class)->make()->toArray();

        $updatedSaleUnitTarget = $this->saleUnitTargetRepo->update($fakeSaleUnitTarget, $saleUnitTarget->id);

        $this->assertModelData($fakeSaleUnitTarget, $updatedSaleUnitTarget->toArray());
        $dbSaleUnitTarget = $this->saleUnitTargetRepo->find($saleUnitTarget->id);
        $this->assertModelData($fakeSaleUnitTarget, $dbSaleUnitTarget->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_sale_unit_target()
    {
        $saleUnitTarget = factory(SaleUnitTarget::class)->create();

        $resp = $this->saleUnitTargetRepo->delete($saleUnitTarget->id);

        $this->assertTrue($resp);
        $this->assertNull(SaleUnitTarget::find($saleUnitTarget->id), 'SaleUnitTarget should not exist in DB');
    }
}
