<?php namespace Tests\Repositories;

use App\Models\PaymentMethods;
use App\Repositories\Backend\PaymentMethodsRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class PaymentMethodsRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var PaymentMethodsRepository
     */
    protected $paymentMethodsRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->paymentMethodsRepo = \App::make(PaymentMethodsRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_payment_methods()
    {
        $paymentMethods = factory(PaymentMethods::class)->make()->toArray();

        $createdPaymentMethods = $this->paymentMethodsRepo->create($paymentMethods);

        $createdPaymentMethods = $createdPaymentMethods->toArray();
        $this->assertArrayHasKey('id', $createdPaymentMethods);
        $this->assertNotNull($createdPaymentMethods['id'], 'Created PaymentMethods must have id specified');
        $this->assertNotNull(PaymentMethods::find($createdPaymentMethods['id']), 'PaymentMethods with given id must be in DB');
        $this->assertModelData($paymentMethods, $createdPaymentMethods);
    }

    /**
     * @test read
     */
    public function test_read_payment_methods()
    {
        $paymentMethods = factory(PaymentMethods::class)->create();

        $dbPaymentMethods = $this->paymentMethodsRepo->find($paymentMethods->id);

        $dbPaymentMethods = $dbPaymentMethods->toArray();
        $this->assertModelData($paymentMethods->toArray(), $dbPaymentMethods);
    }

    /**
     * @test update
     */
    public function test_update_payment_methods()
    {
        $paymentMethods = factory(PaymentMethods::class)->create();
        $fakePaymentMethods = factory(PaymentMethods::class)->make()->toArray();

        $updatedPaymentMethods = $this->paymentMethodsRepo->update($fakePaymentMethods, $paymentMethods->id);

        $this->assertModelData($fakePaymentMethods, $updatedPaymentMethods->toArray());
        $dbPaymentMethods = $this->paymentMethodsRepo->find($paymentMethods->id);
        $this->assertModelData($fakePaymentMethods, $dbPaymentMethods->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_payment_methods()
    {
        $paymentMethods = factory(PaymentMethods::class)->create();

        $resp = $this->paymentMethodsRepo->delete($paymentMethods->id);

        $this->assertTrue($resp);
        $this->assertNull(PaymentMethods::find($paymentMethods->id), 'PaymentMethods should not exist in DB');
    }
}
