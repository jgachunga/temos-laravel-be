<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\QuestionType;

class QuestionTypeApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_question_type()
    {
        $questionType = factory(QuestionType::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/question_types', $questionType
        );

        $this->assertApiResponse($questionType);
    }

    /**
     * @test
     */
    public function test_read_question_type()
    {
        $questionType = factory(QuestionType::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/question_types/'.$questionType->id
        );

        $this->assertApiResponse($questionType->toArray());
    }

    /**
     * @test
     */
    public function test_update_question_type()
    {
        $questionType = factory(QuestionType::class)->create();
        $editedQuestionType = factory(QuestionType::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/question_types/'.$questionType->id,
            $editedQuestionType
        );

        $this->assertApiResponse($editedQuestionType);
    }

    /**
     * @test
     */
    public function test_delete_question_type()
    {
        $questionType = factory(QuestionType::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/question_types/'.$questionType->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/question_types/'.$questionType->id
        );

        $this->response->assertStatus(404);
    }
}
