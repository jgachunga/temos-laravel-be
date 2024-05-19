<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\UserLocationHistory;

class UserLocationHistoryApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_user_location_history()
    {
        $userLocationHistory = factory(UserLocationHistory::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/user_location_histories', $userLocationHistory
        );

        $this->assertApiResponse($userLocationHistory);
    }

    /**
     * @test
     */
    public function test_read_user_location_history()
    {
        $userLocationHistory = factory(UserLocationHistory::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/user_location_histories/'.$userLocationHistory->id
        );

        $this->assertApiResponse($userLocationHistory->toArray());
    }

    /**
     * @test
     */
    public function test_update_user_location_history()
    {
        $userLocationHistory = factory(UserLocationHistory::class)->create();
        $editedUserLocationHistory = factory(UserLocationHistory::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/user_location_histories/'.$userLocationHistory->id,
            $editedUserLocationHistory
        );

        $this->assertApiResponse($editedUserLocationHistory);
    }

    /**
     * @test
     */
    public function test_delete_user_location_history()
    {
        $userLocationHistory = factory(UserLocationHistory::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/user_location_histories/'.$userLocationHistory->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/user_location_histories/'.$userLocationHistory->id
        );

        $this->response->assertStatus(404);
    }
}
