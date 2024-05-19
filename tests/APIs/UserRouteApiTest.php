<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\UserRoute;

class UserRouteApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_user_route()
    {
        $userRoute = factory(UserRoute::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/user_routes', $userRoute
        );

        $this->assertApiResponse($userRoute);
    }

    /**
     * @test
     */
    public function test_read_user_route()
    {
        $userRoute = factory(UserRoute::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/user_routes/'.$userRoute->id
        );

        $this->assertApiResponse($userRoute->toArray());
    }

    /**
     * @test
     */
    public function test_update_user_route()
    {
        $userRoute = factory(UserRoute::class)->create();
        $editedUserRoute = factory(UserRoute::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/user_routes/'.$userRoute->id,
            $editedUserRoute
        );

        $this->assertApiResponse($editedUserRoute);
    }

    /**
     * @test
     */
    public function test_delete_user_route()
    {
        $userRoute = factory(UserRoute::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/user_routes/'.$userRoute->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/user_routes/'.$userRoute->id
        );

        $this->response->assertStatus(404);
    }
}
