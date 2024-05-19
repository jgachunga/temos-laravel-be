<?php namespace Tests\Repositories;

use App\Models\OrderDetail;
use App\Repositories\Backend\OrderDetailRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class OrderDetailRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var OrderDetailRepository
     */
    protected $orderDetailRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->orderDetailRepo = \App::make(OrderDetailRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_order_detail()
    {
        $orderDetail = factory(OrderDetail::class)->make()->toArray();

        $createdOrderDetail = $this->orderDetailRepo->create($orderDetail);

        $createdOrderDetail = $createdOrderDetail->toArray();
        $this->assertArrayHasKey('id', $createdOrderDetail);
        $this->assertNotNull($createdOrderDetail['id'], 'Created OrderDetail must have id specified');
        $this->assertNotNull(OrderDetail::find($createdOrderDetail['id']), 'OrderDetail with given id must be in DB');
        $this->assertModelData($orderDetail, $createdOrderDetail);
    }

    /**
     * @test read
     */
    public function test_read_order_detail()
    {
        $orderDetail = factory(OrderDetail::class)->create();

        $dbOrderDetail = $this->orderDetailRepo->find($orderDetail->id);

        $dbOrderDetail = $dbOrderDetail->toArray();
        $this->assertModelData($orderDetail->toArray(), $dbOrderDetail);
    }

    /**
     * @test update
     */
    public function test_update_order_detail()
    {
        $orderDetail = factory(OrderDetail::class)->create();
        $fakeOrderDetail = factory(OrderDetail::class)->make()->toArray();

        $updatedOrderDetail = $this->orderDetailRepo->update($fakeOrderDetail, $orderDetail->id);

        $this->assertModelData($fakeOrderDetail, $updatedOrderDetail->toArray());
        $dbOrderDetail = $this->orderDetailRepo->find($orderDetail->id);
        $this->assertModelData($fakeOrderDetail, $dbOrderDetail->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_order_detail()
    {
        $orderDetail = factory(OrderDetail::class)->create();

        $resp = $this->orderDetailRepo->delete($orderDetail->id);

        $this->assertTrue($resp);
        $this->assertNull(OrderDetail::find($orderDetail->id), 'OrderDetail should not exist in DB');
    }
}
