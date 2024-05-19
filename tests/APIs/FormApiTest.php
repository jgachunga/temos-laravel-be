<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Form;

class FormApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_form()
    {
        $form = factory(Form::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/forms', $form
        );

        $this->assertApiResponse($form);
    }

    /**
     * @test
     */
    public function test_read_form()
    {
        $form = factory(Form::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/forms/'.$form->id
        );

        $this->assertApiResponse($form->toArray());
    }

    /**
     * @test
     */
    public function test_update_form()
    {
        $form = factory(Form::class)->create();
        $editedForm = factory(Form::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/forms/'.$form->id,
            $editedForm
        );

        $this->assertApiResponse($editedForm);
    }

    /**
     * @test
     */
    public function test_delete_form()
    {
        $form = factory(Form::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/forms/'.$form->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/forms/'.$form->id
        );

        $this->response->assertStatus(404);
    }
}
