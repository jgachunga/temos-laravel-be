<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Teams;

class TeamsApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_teams()
    {
        $teams = factory(Teams::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/teams', $teams
        );

        $this->assertApiResponse($teams);
    }

    /**
     * @test
     */
    public function test_read_teams()
    {
        $teams = factory(Teams::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/teams/'.$teams->id
        );

        $this->assertApiResponse($teams->toArray());
    }

    /**
     * @test
     */
    public function test_update_teams()
    {
        $teams = factory(Teams::class)->create();
        $editedTeams = factory(Teams::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/teams/'.$teams->id,
            $editedTeams
        );

        $this->assertApiResponse($editedTeams);
    }

    /**
     * @test
     */
    public function test_delete_teams()
    {
        $teams = factory(Teams::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/teams/'.$teams->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/teams/'.$teams->id
        );

        $this->response->assertStatus(404);
    }
}
