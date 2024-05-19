<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\InvoiceDetail;

class InvoiceDetailApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_invoice_detail()
    {
        $invoiceDetail = factory(InvoiceDetail::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/invoice_details', $invoiceDetail
        );

        $this->assertApiResponse($invoiceDetail);
    }

    /**
     * @test
     */
    public function test_read_invoice_detail()
    {
        $invoiceDetail = factory(InvoiceDetail::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/invoice_details/'.$invoiceDetail->id
        );

        $this->assertApiResponse($invoiceDetail->toArray());
    }

    /**
     * @test
     */
    public function test_update_invoice_detail()
    {
        $invoiceDetail = factory(InvoiceDetail::class)->create();
        $editedInvoiceDetail = factory(InvoiceDetail::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/invoice_details/'.$invoiceDetail->id,
            $editedInvoiceDetail
        );

        $this->assertApiResponse($editedInvoiceDetail);
    }

    /**
     * @test
     */
    public function test_delete_invoice_detail()
    {
        $invoiceDetail = factory(InvoiceDetail::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/invoice_details/'.$invoiceDetail->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/invoice_details/'.$invoiceDetail->id
        );

        $this->response->assertStatus(404);
    }
}
