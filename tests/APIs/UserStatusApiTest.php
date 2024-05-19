<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\UserStatus;

class UserStatusApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_user_status()
    {
        $userStatus = factory(UserStatus::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/user_statuses', $userStatus
        );

        $this->assertApiResponse($userStatus);
    }

    /**
     * @test
     */
    public function test_read_user_status()
    {
        $userStatus = factory(UserStatus::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/user_statuses/'.$userStatus->id
        );

        $this->assertApiResponse($userStatus->toArray());
    }

    /**
     * @test
     */
    public function test_update_user_status()
    {
        $userStatus = factory(UserStatus::class)->create();
        $editedUserStatus = factory(UserStatus::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/user_statuses/'.$userStatus->id,
            $editedUserStatus
        );

        $this->assertApiResponse($editedUserStatus);
    }

    /**
     * @test
     */
    public function test_delete_user_status()
    {
        $userStatus = factory(UserStatus::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/user_statuses/'.$userStatus->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/user_statuses/'.$userStatus->id
        );

        $this->response->assertStatus(404);
    }
}
