<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\UserClient;

class UserClientApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_user_client()
    {
        $userClient = factory(UserClient::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/user_clients', $userClient
        );

        $this->assertApiResponse($userClient);
    }

    /**
     * @test
     */
    public function test_read_user_client()
    {
        $userClient = factory(UserClient::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/user_clients/'.$userClient->id
        );

        $this->assertApiResponse($userClient->toArray());
    }

    /**
     * @test
     */
    public function test_update_user_client()
    {
        $userClient = factory(UserClient::class)->create();
        $editedUserClient = factory(UserClient::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/user_clients/'.$userClient->id,
            $editedUserClient
        );

        $this->assertApiResponse($editedUserClient);
    }

    /**
     * @test
     */
    public function test_delete_user_client()
    {
        $userClient = factory(UserClient::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/user_clients/'.$userClient->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/user_clients/'.$userClient->id
        );

        $this->response->assertStatus(404);
    }
}
