<?php namespace Tests\Repositories;

use App\Models\InvoiceDetail;
use App\Repositories\Backend\InvoiceDetailRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class InvoiceDetailRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var InvoiceDetailRepository
     */
    protected $invoiceDetailRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->invoiceDetailRepo = \App::make(InvoiceDetailRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_invoice_detail()
    {
        $invoiceDetail = factory(InvoiceDetail::class)->make()->toArray();

        $createdInvoiceDetail = $this->invoiceDetailRepo->create($invoiceDetail);

        $createdInvoiceDetail = $createdInvoiceDetail->toArray();
        $this->assertArrayHasKey('id', $createdInvoiceDetail);
        $this->assertNotNull($createdInvoiceDetail['id'], 'Created InvoiceDetail must have id specified');
        $this->assertNotNull(InvoiceDetail::find($createdInvoiceDetail['id']), 'InvoiceDetail with given id must be in DB');
        $this->assertModelData($invoiceDetail, $createdInvoiceDetail);
    }

    /**
     * @test read
     */
    public function test_read_invoice_detail()
    {
        $invoiceDetail = factory(InvoiceDetail::class)->create();

        $dbInvoiceDetail = $this->invoiceDetailRepo->find($invoiceDetail->id);

        $dbInvoiceDetail = $dbInvoiceDetail->toArray();
        $this->assertModelData($invoiceDetail->toArray(), $dbInvoiceDetail);
    }

    /**
     * @test update
     */
    public function test_update_invoice_detail()
    {
        $invoiceDetail = factory(InvoiceDetail::class)->create();
        $fakeInvoiceDetail = factory(InvoiceDetail::class)->make()->toArray();

        $updatedInvoiceDetail = $this->invoiceDetailRepo->update($fakeInvoiceDetail, $invoiceDetail->id);

        $this->assertModelData($fakeInvoiceDetail, $updatedInvoiceDetail->toArray());
        $dbInvoiceDetail = $this->invoiceDetailRepo->find($invoiceDetail->id);
        $this->assertModelData($fakeInvoiceDetail, $dbInvoiceDetail->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_invoice_detail()
    {
        $invoiceDetail = factory(InvoiceDetail::class)->create();

        $resp = $this->invoiceDetailRepo->delete($invoiceDetail->id);

        $this->assertTrue($resp);
        $this->assertNull(InvoiceDetail::find($invoiceDetail->id), 'InvoiceDetail should not exist in DB');
    }
}
