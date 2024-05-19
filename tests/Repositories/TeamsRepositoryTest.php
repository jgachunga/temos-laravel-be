<?php namespace Tests\Repositories;

use App\Models\Teams;
use App\Repositories\Backend\TeamsRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class TeamsRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var TeamsRepository
     */
    protected $teamsRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->teamsRepo = \App::make(TeamsRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_teams()
    {
        $teams = factory(Teams::class)->make()->toArray();

        $createdTeams = $this->teamsRepo->create($teams);

        $createdTeams = $createdTeams->toArray();
        $this->assertArrayHasKey('id', $createdTeams);
        $this->assertNotNull($createdTeams['id'], 'Created Teams must have id specified');
        $this->assertNotNull(Teams::find($createdTeams['id']), 'Teams with given id must be in DB');
        $this->assertModelData($teams, $createdTeams);
    }

    /**
     * @test read
     */
    public function test_read_teams()
    {
        $teams = factory(Teams::class)->create();

        $dbTeams = $this->teamsRepo->find($teams->id);

        $dbTeams = $dbTeams->toArray();
        $this->assertModelData($teams->toArray(), $dbTeams);
    }

    /**
     * @test update
     */
    public function test_update_teams()
    {
        $teams = factory(Teams::class)->create();
        $fakeTeams = factory(Teams::class)->make()->toArray();

        $updatedTeams = $this->teamsRepo->update($fakeTeams, $teams->id);

        $this->assertModelData($fakeTeams, $updatedTeams->toArray());
        $dbTeams = $this->teamsRepo->find($teams->id);
        $this->assertModelData($fakeTeams, $dbTeams->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_teams()
    {
        $teams = factory(Teams::class)->create();

        $resp = $this->teamsRepo->delete($teams->id);

        $this->assertTrue($resp);
        $this->assertNull(Teams::find($teams->id), 'Teams should not exist in DB');
    }
}
