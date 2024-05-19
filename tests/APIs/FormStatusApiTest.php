<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\FormStatus;

class FormStatusApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_form_status()
    {
        $formStatus = factory(FormStatus::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/form_statuses', $formStatus
        );

        $this->assertApiResponse($formStatus);
    }

    /**
     * @test
     */
    public function test_read_form_status()
    {
        $formStatus = factory(FormStatus::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/form_statuses/'.$formStatus->id
        );

        $this->assertApiResponse($formStatus->toArray());
    }

    /**
     * @test
     */
    public function test_update_form_status()
    {
        $formStatus = factory(FormStatus::class)->create();
        $editedFormStatus = factory(FormStatus::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/form_statuses/'.$formStatus->id,
            $editedFormStatus
        );

        $this->assertApiResponse($editedFormStatus);
    }

    /**
     * @test
     */
    public function test_delete_form_status()
    {
        $formStatus = factory(FormStatus::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/form_statuses/'.$formStatus->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/form_statuses/'.$formStatus->id
        );

        $this->response->assertStatus(404);
    }
}
