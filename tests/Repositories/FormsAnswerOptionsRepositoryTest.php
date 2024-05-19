<?php namespace Tests\Repositories;

use App\Models\FormsAnswerOptions;
use App\Repositories\Backend\FormsAnswerOptionsRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class FormsAnswerOptionsRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var FormsAnswerOptionsRepository
     */
    protected $formsAnswerOptionsRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->formsAnswerOptionsRepo = \App::make(FormsAnswerOptionsRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_forms_answer_options()
    {
        $formsAnswerOptions = factory(FormsAnswerOptions::class)->make()->toArray();

        $createdFormsAnswerOptions = $this->formsAnswerOptionsRepo->create($formsAnswerOptions);

        $createdFormsAnswerOptions = $createdFormsAnswerOptions->toArray();
        $this->assertArrayHasKey('id', $createdFormsAnswerOptions);
        $this->assertNotNull($createdFormsAnswerOptions['id'], 'Created FormsAnswerOptions must have id specified');
        $this->assertNotNull(FormsAnswerOptions::find($createdFormsAnswerOptions['id']), 'FormsAnswerOptions with given id must be in DB');
        $this->assertModelData($formsAnswerOptions, $createdFormsAnswerOptions);
    }

    /**
     * @test read
     */
    public function test_read_forms_answer_options()
    {
        $formsAnswerOptions = factory(FormsAnswerOptions::class)->create();

        $dbFormsAnswerOptions = $this->formsAnswerOptionsRepo->find($formsAnswerOptions->id);

        $dbFormsAnswerOptions = $dbFormsAnswerOptions->toArray();
        $this->assertModelData($formsAnswerOptions->toArray(), $dbFormsAnswerOptions);
    }

    /**
     * @test update
     */
    public function test_update_forms_answer_options()
    {
        $formsAnswerOptions = factory(FormsAnswerOptions::class)->create();
        $fakeFormsAnswerOptions = factory(FormsAnswerOptions::class)->make()->toArray();

        $updatedFormsAnswerOptions = $this->formsAnswerOptionsRepo->update($fakeFormsAnswerOptions, $formsAnswerOptions->id);

        $this->assertModelData($fakeFormsAnswerOptions, $updatedFormsAnswerOptions->toArray());
        $dbFormsAnswerOptions = $this->formsAnswerOptionsRepo->find($formsAnswerOptions->id);
        $this->assertModelData($fakeFormsAnswerOptions, $dbFormsAnswerOptions->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_forms_answer_options()
    {
        $formsAnswerOptions = factory(FormsAnswerOptions::class)->create();

        $resp = $this->formsAnswerOptionsRepo->delete($formsAnswerOptions->id);

        $this->assertTrue($resp);
        $this->assertNull(FormsAnswerOptions::find($formsAnswerOptions->id), 'FormsAnswerOptions should not exist in DB');
    }
}
