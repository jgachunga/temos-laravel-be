<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\UserTarget;

class UserTargetApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_user_target()
    {
        $userTarget = factory(UserTarget::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/user_targets', $userTarget
        );

        $this->assertApiResponse($userTarget);
    }

    /**
     * @test
     */
    public function test_read_user_target()
    {
        $userTarget = factory(UserTarget::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/user_targets/'.$userTarget->id
        );

        $this->assertApiResponse($userTarget->toArray());
    }

    /**
     * @test
     */
    public function test_update_user_target()
    {
        $userTarget = factory(UserTarget::class)->create();
        $editedUserTarget = factory(UserTarget::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/user_targets/'.$userTarget->id,
            $editedUserTarget
        );

        $this->assertApiResponse($editedUserTarget);
    }

    /**
     * @test
     */
    public function test_delete_user_target()
    {
        $userTarget = factory(UserTarget::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/user_targets/'.$userTarget->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/user_targets/'.$userTarget->id
        );

        $this->response->assertStatus(404);
    }
}
