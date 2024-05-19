<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\QuestionOption;

class QuestionOptionApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_question_option()
    {
        $questionOption = factory(QuestionOption::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/question_options', $questionOption
        );

        $this->assertApiResponse($questionOption);
    }

    /**
     * @test
     */
    public function test_read_question_option()
    {
        $questionOption = factory(QuestionOption::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/question_options/'.$questionOption->id
        );

        $this->assertApiResponse($questionOption->toArray());
    }

    /**
     * @test
     */
    public function test_update_question_option()
    {
        $questionOption = factory(QuestionOption::class)->create();
        $editedQuestionOption = factory(QuestionOption::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/question_options/'.$questionOption->id,
            $editedQuestionOption
        );

        $this->assertApiResponse($editedQuestionOption);
    }

    /**
     * @test
     */
    public function test_delete_question_option()
    {
        $questionOption = factory(QuestionOption::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/question_options/'.$questionOption->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/question_options/'.$questionOption->id
        );

        $this->response->assertStatus(404);
    }
}
