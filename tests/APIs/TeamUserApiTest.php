<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\TeamUser;

class TeamUserApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_team_user()
    {
        $teamUser = factory(TeamUser::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/team_users', $teamUser
        );

        $this->assertApiResponse($teamUser);
    }

    /**
     * @test
     */
    public function test_read_team_user()
    {
        $teamUser = factory(TeamUser::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/team_users/'.$teamUser->id
        );

        $this->assertApiResponse($teamUser->toArray());
    }

    /**
     * @test
     */
    public function test_update_team_user()
    {
        $teamUser = factory(TeamUser::class)->create();
        $editedTeamUser = factory(TeamUser::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/team_users/'.$teamUser->id,
            $editedTeamUser
        );

        $this->assertApiResponse($editedTeamUser);
    }

    /**
     * @test
     */
    public function test_delete_team_user()
    {
        $teamUser = factory(TeamUser::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/team_users/'.$teamUser->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/team_users/'.$teamUser->id
        );

        $this->response->assertStatus(404);
    }
}
