<?php namespace Tests\Repositories;

use App\Models\SaleStructure;
use App\Repositories\Backend\SaleStructureRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class SaleStructureRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var SaleStructureRepository
     */
    protected $saleStructureRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->saleStructureRepo = \App::make(SaleStructureRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_sale_structure()
    {
        $saleStructure = factory(SaleStructure::class)->make()->toArray();

        $createdSaleStructure = $this->saleStructureRepo->create($saleStructure);

        $createdSaleStructure = $createdSaleStructure->toArray();
        $this->assertArrayHasKey('id', $createdSaleStructure);
        $this->assertNotNull($createdSaleStructure['id'], 'Created SaleStructure must have id specified');
        $this->assertNotNull(SaleStructure::find($createdSaleStructure['id']), 'SaleStructure with given id must be in DB');
        $this->assertModelData($saleStructure, $createdSaleStructure);
    }

    /**
     * @test read
     */
    public function test_read_sale_structure()
    {
        $saleStructure = factory(SaleStructure::class)->create();

        $dbSaleStructure = $this->saleStructureRepo->find($saleStructure->id);

        $dbSaleStructure = $dbSaleStructure->toArray();
        $this->assertModelData($saleStructure->toArray(), $dbSaleStructure);
    }

    /**
     * @test update
     */
    public function test_update_sale_structure()
    {
        $saleStructure = factory(SaleStructure::class)->create();
        $fakeSaleStructure = factory(SaleStructure::class)->make()->toArray();

        $updatedSaleStructure = $this->saleStructureRepo->update($fakeSaleStructure, $saleStructure->id);

        $this->assertModelData($fakeSaleStructure, $updatedSaleStructure->toArray());
        $dbSaleStructure = $this->saleStructureRepo->find($saleStructure->id);
        $this->assertModelData($fakeSaleStructure, $dbSaleStructure->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_sale_structure()
    {
        $saleStructure = factory(SaleStructure::class)->create();

        $resp = $this->saleStructureRepo->delete($saleStructure->id);

        $this->assertTrue($resp);
        $this->assertNull(SaleStructure::find($saleStructure->id), 'SaleStructure should not exist in DB');
    }
}
