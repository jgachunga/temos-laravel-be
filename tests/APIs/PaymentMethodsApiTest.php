<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\PaymentMethods;

class PaymentMethodsApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_payment_methods()
    {
        $paymentMethods = factory(PaymentMethods::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/payment_methods', $paymentMethods
        );

        $this->assertApiResponse($paymentMethods);
    }

    /**
     * @test
     */
    public function test_read_payment_methods()
    {
        $paymentMethods = factory(PaymentMethods::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/payment_methods/'.$paymentMethods->id
        );

        $this->assertApiResponse($paymentMethods->toArray());
    }

    /**
     * @test
     */
    public function test_update_payment_methods()
    {
        $paymentMethods = factory(PaymentMethods::class)->create();
        $editedPaymentMethods = factory(PaymentMethods::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/payment_methods/'.$paymentMethods->id,
            $editedPaymentMethods
        );

        $this->assertApiResponse($editedPaymentMethods);
    }

    /**
     * @test
     */
    public function test_delete_payment_methods()
    {
        $paymentMethods = factory(PaymentMethods::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/payment_methods/'.$paymentMethods->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/payment_methods/'.$paymentMethods->id
        );

        $this->response->assertStatus(404);
    }
}
