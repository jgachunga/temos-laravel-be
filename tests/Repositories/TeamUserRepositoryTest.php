<?php namespace Tests\Repositories;

use App\Models\TeamUser;
use App\Repositories\Backend\TeamUserRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class TeamUserRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var TeamUserRepository
     */
    protected $teamUserRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->teamUserRepo = \App::make(TeamUserRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_team_user()
    {
        $teamUser = factory(TeamUser::class)->make()->toArray();

        $createdTeamUser = $this->teamUserRepo->create($teamUser);

        $createdTeamUser = $createdTeamUser->toArray();
        $this->assertArrayHasKey('id', $createdTeamUser);
        $this->assertNotNull($createdTeamUser['id'], 'Created TeamUser must have id specified');
        $this->assertNotNull(TeamUser::find($createdTeamUser['id']), 'TeamUser with given id must be in DB');
        $this->assertModelData($teamUser, $createdTeamUser);
    }

    /**
     * @test read
     */
    public function test_read_team_user()
    {
        $teamUser = factory(TeamUser::class)->create();

        $dbTeamUser = $this->teamUserRepo->find($teamUser->id);

        $dbTeamUser = $dbTeamUser->toArray();
        $this->assertModelData($teamUser->toArray(), $dbTeamUser);
    }

    /**
     * @test update
     */
    public function test_update_team_user()
    {
        $teamUser = factory(TeamUser::class)->create();
        $fakeTeamUser = factory(TeamUser::class)->make()->toArray();

        $updatedTeamUser = $this->teamUserRepo->update($fakeTeamUser, $teamUser->id);

        $this->assertModelData($fakeTeamUser, $updatedTeamUser->toArray());
        $dbTeamUser = $this->teamUserRepo->find($teamUser->id);
        $this->assertModelData($fakeTeamUser, $dbTeamUser->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_team_user()
    {
        $teamUser = factory(TeamUser::class)->create();

        $resp = $this->teamUserRepo->delete($teamUser->id);

        $this->assertTrue($resp);
        $this->assertNull(TeamUser::find($teamUser->id), 'TeamUser should not exist in DB');
    }
}
