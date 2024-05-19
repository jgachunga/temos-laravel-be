<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\FormsAnswers;

class FormsAnswersApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_forms_answers()
    {
        $formsAnswers = factory(FormsAnswers::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/forms_answers', $formsAnswers
        );

        $this->assertApiResponse($formsAnswers);
    }

    /**
     * @test
     */
    public function test_read_forms_answers()
    {
        $formsAnswers = factory(FormsAnswers::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/forms_answers/'.$formsAnswers->id
        );

        $this->assertApiResponse($formsAnswers->toArray());
    }

    /**
     * @test
     */
    public function test_update_forms_answers()
    {
        $formsAnswers = factory(FormsAnswers::class)->create();
        $editedFormsAnswers = factory(FormsAnswers::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/forms_answers/'.$formsAnswers->id,
            $editedFormsAnswers
        );

        $this->assertApiResponse($editedFormsAnswers);
    }

    /**
     * @test
     */
    public function test_delete_forms_answers()
    {
        $formsAnswers = factory(FormsAnswers::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/forms_answers/'.$formsAnswers->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/forms_answers/'.$formsAnswers->id
        );

        $this->response->assertStatus(404);
    }
}
