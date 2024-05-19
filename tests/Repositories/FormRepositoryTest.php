<?php namespace Tests\Repositories;

use App\Models\Form;
use App\Repositories\Backend\FormRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class FormRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var FormRepository
     */
    protected $formRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->formRepo = \App::make(FormRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_form()
    {
        $form = factory(Form::class)->make()->toArray();

        $createdForm = $this->formRepo->create($form);

        $createdForm = $createdForm->toArray();
        $this->assertArrayHasKey('id', $createdForm);
        $this->assertNotNull($createdForm['id'], 'Created Form must have id specified');
        $this->assertNotNull(Form::find($createdForm['id']), 'Form with given id must be in DB');
        $this->assertModelData($form, $createdForm);
    }

    /**
     * @test read
     */
    public function test_read_form()
    {
        $form = factory(Form::class)->create();

        $dbForm = $this->formRepo->find($form->id);

        $dbForm = $dbForm->toArray();
        $this->assertModelData($form->toArray(), $dbForm);
    }

    /**
     * @test update
     */
    public function test_update_form()
    {
        $form = factory(Form::class)->create();
        $fakeForm = factory(Form::class)->make()->toArray();

        $updatedForm = $this->formRepo->update($fakeForm, $form->id);

        $this->assertModelData($fakeForm, $updatedForm->toArray());
        $dbForm = $this->formRepo->find($form->id);
        $this->assertModelData($fakeForm, $dbForm->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_form()
    {
        $form = factory(Form::class)->create();

        $resp = $this->formRepo->delete($form->id);

        $this->assertTrue($resp);
        $this->assertNull(Form::find($form->id), 'Form should not exist in DB');
    }
}
