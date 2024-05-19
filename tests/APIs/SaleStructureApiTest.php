<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\SaleStructure;

class SaleStructureApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_sale_structure()
    {
        $saleStructure = factory(SaleStructure::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/sale_structures', $saleStructure
        );

        $this->assertApiResponse($saleStructure);
    }

    /**
     * @test
     */
    public function test_read_sale_structure()
    {
        $saleStructure = factory(SaleStructure::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/sale_structures/'.$saleStructure->id
        );

        $this->assertApiResponse($saleStructure->toArray());
    }

    /**
     * @test
     */
    public function test_update_sale_structure()
    {
        $saleStructure = factory(SaleStructure::class)->create();
        $editedSaleStructure = factory(SaleStructure::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/sale_structures/'.$saleStructure->id,
            $editedSaleStructure
        );

        $this->assertApiResponse($editedSaleStructure);
    }

    /**
     * @test
     */
    public function test_delete_sale_structure()
    {
        $saleStructure = factory(SaleStructure::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/sale_structures/'.$saleStructure->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/sale_structures/'.$saleStructure->id
        );

        $this->response->assertStatus(404);
    }
}
