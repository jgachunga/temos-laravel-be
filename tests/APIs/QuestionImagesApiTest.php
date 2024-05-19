<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\QuestionImages;

class QuestionImagesApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_question_images()
    {
        $questionImages = factory(QuestionImages::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/question_images', $questionImages
        );

        $this->assertApiResponse($questionImages);
    }

    /**
     * @test
     */
    public function test_read_question_images()
    {
        $questionImages = factory(QuestionImages::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/question_images/'.$questionImages->id
        );

        $this->assertApiResponse($questionImages->toArray());
    }

    /**
     * @test
     */
    public function test_update_question_images()
    {
        $questionImages = factory(QuestionImages::class)->create();
        $editedQuestionImages = factory(QuestionImages::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/question_images/'.$questionImages->id,
            $editedQuestionImages
        );

        $this->assertApiResponse($editedQuestionImages);
    }

    /**
     * @test
     */
    public function test_delete_question_images()
    {
        $questionImages = factory(QuestionImages::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/question_images/'.$questionImages->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/question_images/'.$questionImages->id
        );

        $this->response->assertStatus(404);
    }
}
