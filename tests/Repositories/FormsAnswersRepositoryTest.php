<?php namespace Tests\Repositories;

use App\Models\FormsAnswers;
use App\Repositories\Backend\FormsAnswersRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class FormsAnswersRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var FormsAnswersRepository
     */
    protected $formsAnswersRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->formsAnswersRepo = \App::make(FormsAnswersRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_forms_answers()
    {
        $formsAnswers = factory(FormsAnswers::class)->make()->toArray();

        $createdFormsAnswers = $this->formsAnswersRepo->create($formsAnswers);

        $createdFormsAnswers = $createdFormsAnswers->toArray();
        $this->assertArrayHasKey('id', $createdFormsAnswers);
        $this->assertNotNull($createdFormsAnswers['id'], 'Created FormsAnswers must have id specified');
        $this->assertNotNull(FormsAnswers::find($createdFormsAnswers['id']), 'FormsAnswers with given id must be in DB');
        $this->assertModelData($formsAnswers, $createdFormsAnswers);
    }

    /**
     * @test read
     */
    public function test_read_forms_answers()
    {
        $formsAnswers = factory(FormsAnswers::class)->create();

        $dbFormsAnswers = $this->formsAnswersRepo->find($formsAnswers->id);

        $dbFormsAnswers = $dbFormsAnswers->toArray();
        $this->assertModelData($formsAnswers->toArray(), $dbFormsAnswers);
    }

    /**
     * @test update
     */
    public function test_update_forms_answers()
    {
        $formsAnswers = factory(FormsAnswers::class)->create();
        $fakeFormsAnswers = factory(FormsAnswers::class)->make()->toArray();

        $updatedFormsAnswers = $this->formsAnswersRepo->update($fakeFormsAnswers, $formsAnswers->id);

        $this->assertModelData($fakeFormsAnswers, $updatedFormsAnswers->toArray());
        $dbFormsAnswers = $this->formsAnswersRepo->find($formsAnswers->id);
        $this->assertModelData($fakeFormsAnswers, $dbFormsAnswers->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_forms_answers()
    {
        $formsAnswers = factory(FormsAnswers::class)->create();

        $resp = $this->formsAnswersRepo->delete($formsAnswers->id);

        $this->assertTrue($resp);
        $this->assertNull(FormsAnswers::find($formsAnswers->id), 'FormsAnswers should not exist in DB');
    }
}
