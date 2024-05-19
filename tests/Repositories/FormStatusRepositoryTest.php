<?php namespace Tests\Repositories;

use App\Models\FormStatus;
use App\Repositories\Backend\FormStatusRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class FormStatusRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var FormStatusRepository
     */
    protected $formStatusRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->formStatusRepo = \App::make(FormStatusRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_form_status()
    {
        $formStatus = factory(FormStatus::class)->make()->toArray();

        $createdFormStatus = $this->formStatusRepo->create($formStatus);

        $createdFormStatus = $createdFormStatus->toArray();
        $this->assertArrayHasKey('id', $createdFormStatus);
        $this->assertNotNull($createdFormStatus['id'], 'Created FormStatus must have id specified');
        $this->assertNotNull(FormStatus::find($createdFormStatus['id']), 'FormStatus with given id must be in DB');
        $this->assertModelData($formStatus, $createdFormStatus);
    }

    /**
     * @test read
     */
    public function test_read_form_status()
    {
        $formStatus = factory(FormStatus::class)->create();

        $dbFormStatus = $this->formStatusRepo->find($formStatus->id);

        $dbFormStatus = $dbFormStatus->toArray();
        $this->assertModelData($formStatus->toArray(), $dbFormStatus);
    }

    /**
     * @test update
     */
    public function test_update_form_status()
    {
        $formStatus = factory(FormStatus::class)->create();
        $fakeFormStatus = factory(FormStatus::class)->make()->toArray();

        $updatedFormStatus = $this->formStatusRepo->update($fakeFormStatus, $formStatus->id);

        $this->assertModelData($fakeFormStatus, $updatedFormStatus->toArray());
        $dbFormStatus = $this->formStatusRepo->find($formStatus->id);
        $this->assertModelData($fakeFormStatus, $dbFormStatus->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_form_status()
    {
        $formStatus = factory(FormStatus::class)->create();

        $resp = $this->formStatusRepo->delete($formStatus->id);

        $this->assertTrue($resp);
        $this->assertNull(FormStatus::find($formStatus->id), 'FormStatus should not exist in DB');
    }
}
