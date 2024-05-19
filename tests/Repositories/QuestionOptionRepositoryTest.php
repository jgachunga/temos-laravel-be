<?php namespace Tests\Repositories;

use App\Models\QuestionOption;
use App\Repositories\Backend\QuestionOptionRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class QuestionOptionRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var QuestionOptionRepository
     */
    protected $questionOptionRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->questionOptionRepo = \App::make(QuestionOptionRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_question_option()
    {
        $questionOption = factory(QuestionOption::class)->make()->toArray();

        $createdQuestionOption = $this->questionOptionRepo->create($questionOption);

        $createdQuestionOption = $createdQuestionOption->toArray();
        $this->assertArrayHasKey('id', $createdQuestionOption);
        $this->assertNotNull($createdQuestionOption['id'], 'Created QuestionOption must have id specified');
        $this->assertNotNull(QuestionOption::find($createdQuestionOption['id']), 'QuestionOption with given id must be in DB');
        $this->assertModelData($questionOption, $createdQuestionOption);
    }

    /**
     * @test read
     */
    public function test_read_question_option()
    {
        $questionOption = factory(QuestionOption::class)->create();

        $dbQuestionOption = $this->questionOptionRepo->find($questionOption->id);

        $dbQuestionOption = $dbQuestionOption->toArray();
        $this->assertModelData($questionOption->toArray(), $dbQuestionOption);
    }

    /**
     * @test update
     */
    public function test_update_question_option()
    {
        $questionOption = factory(QuestionOption::class)->create();
        $fakeQuestionOption = factory(QuestionOption::class)->make()->toArray();

        $updatedQuestionOption = $this->questionOptionRepo->update($fakeQuestionOption, $questionOption->id);

        $this->assertModelData($fakeQuestionOption, $updatedQuestionOption->toArray());
        $dbQuestionOption = $this->questionOptionRepo->find($questionOption->id);
        $this->assertModelData($fakeQuestionOption, $dbQuestionOption->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_question_option()
    {
        $questionOption = factory(QuestionOption::class)->create();

        $resp = $this->questionOptionRepo->delete($questionOption->id);

        $this->assertTrue($resp);
        $this->assertNull(QuestionOption::find($questionOption->id), 'QuestionOption should not exist in DB');
    }
}
