<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\FormsAnswerOptions;

class FormsAnswerOptionsApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_forms_answer_options()
    {
        $formsAnswerOptions = factory(FormsAnswerOptions::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/forms_answer_options', $formsAnswerOptions
        );

        $this->assertApiResponse($formsAnswerOptions);
    }

    /**
     * @test
     */
    public function test_read_forms_answer_options()
    {
        $formsAnswerOptions = factory(FormsAnswerOptions::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/forms_answer_options/'.$formsAnswerOptions->id
        );

        $this->assertApiResponse($formsAnswerOptions->toArray());
    }

    /**
     * @test
     */
    public function test_update_forms_answer_options()
    {
        $formsAnswerOptions = factory(FormsAnswerOptions::class)->create();
        $editedFormsAnswerOptions = factory(FormsAnswerOptions::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/forms_answer_options/'.$formsAnswerOptions->id,
            $editedFormsAnswerOptions
        );

        $this->assertApiResponse($editedFormsAnswerOptions);
    }

    /**
     * @test
     */
    public function test_delete_forms_answer_options()
    {
        $formsAnswerOptions = factory(FormsAnswerOptions::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/forms_answer_options/'.$formsAnswerOptions->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/forms_answer_options/'.$formsAnswerOptions->id
        );

        $this->response->assertStatus(404);
    }
}
