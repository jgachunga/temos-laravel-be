<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\FormsAnswered;

class FormsAnsweredApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_forms_answered()
    {
        $formsAnswered = factory(FormsAnswered::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/forms_answereds', $formsAnswered
        );

        $this->assertApiResponse($formsAnswered);
    }

    /**
     * @test
     */
    public function test_read_forms_answered()
    {
        $formsAnswered = factory(FormsAnswered::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/forms_answereds/'.$formsAnswered->id
        );

        $this->assertApiResponse($formsAnswered->toArray());
    }

    /**
     * @test
     */
    public function test_update_forms_answered()
    {
        $formsAnswered = factory(FormsAnswered::class)->create();
        $editedFormsAnswered = factory(FormsAnswered::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/forms_answereds/'.$formsAnswered->id,
            $editedFormsAnswered
        );

        $this->assertApiResponse($editedFormsAnswered);
    }

    /**
     * @test
     */
    public function test_delete_forms_answered()
    {
        $formsAnswered = factory(FormsAnswered::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/forms_answereds/'.$formsAnswered->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/forms_answereds/'.$formsAnswered->id
        );

        $this->response->assertStatus(404);
    }
}
