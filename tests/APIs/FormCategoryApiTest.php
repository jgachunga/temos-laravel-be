<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\FormCategory;

class FormCategoryApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_form_category()
    {
        $formCategory = factory(FormCategory::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/form_categories', $formCategory
        );

        $this->assertApiResponse($formCategory);
    }

    /**
     * @test
     */
    public function test_read_form_category()
    {
        $formCategory = factory(FormCategory::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/form_categories/'.$formCategory->id
        );

        $this->assertApiResponse($formCategory->toArray());
    }

    /**
     * @test
     */
    public function test_update_form_category()
    {
        $formCategory = factory(FormCategory::class)->create();
        $editedFormCategory = factory(FormCategory::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/form_categories/'.$formCategory->id,
            $editedFormCategory
        );

        $this->assertApiResponse($editedFormCategory);
    }

    /**
     * @test
     */
    public function test_delete_form_category()
    {
        $formCategory = factory(FormCategory::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/form_categories/'.$formCategory->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/form_categories/'.$formCategory->id
        );

        $this->response->assertStatus(404);
    }
}
