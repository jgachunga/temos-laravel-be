<?php namespace Tests\Repositories;

use App\Models\QuestionType;
use App\Repositories\Backend\QuestionTypeRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class QuestionTypeRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var QuestionTypeRepository
     */
    protected $questionTypeRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->questionTypeRepo = \App::make(QuestionTypeRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_question_type()
    {
        $questionType = factory(QuestionType::class)->make()->toArray();

        $createdQuestionType = $this->questionTypeRepo->create($questionType);

        $createdQuestionType = $createdQuestionType->toArray();
        $this->assertArrayHasKey('id', $createdQuestionType);
        $this->assertNotNull($createdQuestionType['id'], 'Created QuestionType must have id specified');
        $this->assertNotNull(QuestionType::find($createdQuestionType['id']), 'QuestionType with given id must be in DB');
        $this->assertModelData($questionType, $createdQuestionType);
    }

    /**
     * @test read
     */
    public function test_read_question_type()
    {
        $questionType = factory(QuestionType::class)->create();

        $dbQuestionType = $this->questionTypeRepo->find($questionType->id);

        $dbQuestionType = $dbQuestionType->toArray();
        $this->assertModelData($questionType->toArray(), $dbQuestionType);
    }

    /**
     * @test update
     */
    public function test_update_question_type()
    {
        $questionType = factory(QuestionType::class)->create();
        $fakeQuestionType = factory(QuestionType::class)->make()->toArray();

        $updatedQuestionType = $this->questionTypeRepo->update($fakeQuestionType, $questionType->id);

        $this->assertModelData($fakeQuestionType, $updatedQuestionType->toArray());
        $dbQuestionType = $this->questionTypeRepo->find($questionType->id);
        $this->assertModelData($fakeQuestionType, $dbQuestionType->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_question_type()
    {
        $questionType = factory(QuestionType::class)->create();

        $resp = $this->questionTypeRepo->delete($questionType->id);

        $this->assertTrue($resp);
        $this->assertNull(QuestionType::find($questionType->id), 'QuestionType should not exist in DB');
    }
}
