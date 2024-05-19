<?php namespace Tests\Repositories;

use App\Models\UserTarget;
use App\Repositories\Backend\UserTargetRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class UserTargetRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var UserTargetRepository
     */
    protected $userTargetRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->userTargetRepo = \App::make(UserTargetRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_user_target()
    {
        $userTarget = factory(UserTarget::class)->make()->toArray();

        $createdUserTarget = $this->userTargetRepo->create($userTarget);

        $createdUserTarget = $createdUserTarget->toArray();
        $this->assertArrayHasKey('id', $createdUserTarget);
        $this->assertNotNull($createdUserTarget['id'], 'Created UserTarget must have id specified');
        $this->assertNotNull(UserTarget::find($createdUserTarget['id']), 'UserTarget with given id must be in DB');
        $this->assertModelData($userTarget, $createdUserTarget);
    }

    /**
     * @test read
     */
    public function test_read_user_target()
    {
        $userTarget = factory(UserTarget::class)->create();

        $dbUserTarget = $this->userTargetRepo->find($userTarget->id);

        $dbUserTarget = $dbUserTarget->toArray();
        $this->assertModelData($userTarget->toArray(), $dbUserTarget);
    }

    /**
     * @test update
     */
    public function test_update_user_target()
    {
        $userTarget = factory(UserTarget::class)->create();
        $fakeUserTarget = factory(UserTarget::class)->make()->toArray();

        $updatedUserTarget = $this->userTargetRepo->update($fakeUserTarget, $userTarget->id);

        $this->assertModelData($fakeUserTarget, $updatedUserTarget->toArray());
        $dbUserTarget = $this->userTargetRepo->find($userTarget->id);
        $this->assertModelData($fakeUserTarget, $dbUserTarget->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_user_target()
    {
        $userTarget = factory(UserTarget::class)->create();

        $resp = $this->userTargetRepo->delete($userTarget->id);

        $this->assertTrue($resp);
        $this->assertNull(UserTarget::find($userTarget->id), 'UserTarget should not exist in DB');
    }
}
