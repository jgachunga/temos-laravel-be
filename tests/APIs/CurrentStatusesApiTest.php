<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\CurrentStatuses;

class CurrentStatusesApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_current_statuses()
    {
        $currentStatuses = factory(CurrentStatuses::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/current_statuses', $currentStatuses
        );

        $this->assertApiResponse($currentStatuses);
    }

    /**
     * @test
     */
    public function test_read_current_statuses()
    {
        $currentStatuses = factory(CurrentStatuses::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/current_statuses/'.$currentStatuses->id
        );

        $this->assertApiResponse($currentStatuses->toArray());
    }

    /**
     * @test
     */
    public function test_update_current_statuses()
    {
        $currentStatuses = factory(CurrentStatuses::class)->create();
        $editedCurrentStatuses = factory(CurrentStatuses::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/current_statuses/'.$currentStatuses->id,
            $editedCurrentStatuses
        );

        $this->assertApiResponse($editedCurrentStatuses);
    }

    /**
     * @test
     */
    public function test_delete_current_statuses()
    {
        $currentStatuses = factory(CurrentStatuses::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/current_statuses/'.$currentStatuses->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/current_statuses/'.$currentStatuses->id
        );

        $this->response->assertStatus(404);
    }
}
