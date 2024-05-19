<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\FormPhoto;

class FormPhotoApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_form_photo()
    {
        $formPhoto = factory(FormPhoto::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/form_photos', $formPhoto
        );

        $this->assertApiResponse($formPhoto);
    }

    /**
     * @test
     */
    public function test_read_form_photo()
    {
        $formPhoto = factory(FormPhoto::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/form_photos/'.$formPhoto->id
        );

        $this->assertApiResponse($formPhoto->toArray());
    }

    /**
     * @test
     */
    public function test_update_form_photo()
    {
        $formPhoto = factory(FormPhoto::class)->create();
        $editedFormPhoto = factory(FormPhoto::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/form_photos/'.$formPhoto->id,
            $editedFormPhoto
        );

        $this->assertApiResponse($editedFormPhoto);
    }

    /**
     * @test
     */
    public function test_delete_form_photo()
    {
        $formPhoto = factory(FormPhoto::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/form_photos/'.$formPhoto->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/form_photos/'.$formPhoto->id
        );

        $this->response->assertStatus(404);
    }
}
