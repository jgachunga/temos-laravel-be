<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\SaleUnitTarget;

class SaleUnitTargetApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_sale_unit_target()
    {
        $saleUnitTarget = factory(SaleUnitTarget::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/sale_unit_targets', $saleUnitTarget
        );

        $this->assertApiResponse($saleUnitTarget);
    }

    /**
     * @test
     */
    public function test_read_sale_unit_target()
    {
        $saleUnitTarget = factory(SaleUnitTarget::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/sale_unit_targets/'.$saleUnitTarget->id
        );

        $this->assertApiResponse($saleUnitTarget->toArray());
    }

    /**
     * @test
     */
    public function test_update_sale_unit_target()
    {
        $saleUnitTarget = factory(SaleUnitTarget::class)->create();
        $editedSaleUnitTarget = factory(SaleUnitTarget::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/sale_unit_targets/'.$saleUnitTarget->id,
            $editedSaleUnitTarget
        );

        $this->assertApiResponse($editedSaleUnitTarget);
    }

    /**
     * @test
     */
    public function test_delete_sale_unit_target()
    {
        $saleUnitTarget = factory(SaleUnitTarget::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/sale_unit_targets/'.$saleUnitTarget->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/sale_unit_targets/'.$saleUnitTarget->id
        );

        $this->response->assertStatus(404);
    }
}
