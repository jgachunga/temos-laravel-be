<?php namespace Tests\Repositories;

use App\Models\UserStatus;
use App\Repositories\Backend\UserStatusRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class UserStatusRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var UserStatusRepository
     */
    protected $userStatusRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->userStatusRepo = \App::make(UserStatusRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_user_status()
    {
        $userStatus = factory(UserStatus::class)->make()->toArray();

        $createdUserStatus = $this->userStatusRepo->create($userStatus);

        $createdUserStatus = $createdUserStatus->toArray();
        $this->assertArrayHasKey('id', $createdUserStatus);
        $this->assertNotNull($createdUserStatus['id'], 'Created UserStatus must have id specified');
        $this->assertNotNull(UserStatus::find($createdUserStatus['id']), 'UserStatus with given id must be in DB');
        $this->assertModelData($userStatus, $createdUserStatus);
    }

    /**
     * @test read
     */
    public function test_read_user_status()
    {
        $userStatus = factory(UserStatus::class)->create();

        $dbUserStatus = $this->userStatusRepo->find($userStatus->id);

        $dbUserStatus = $dbUserStatus->toArray();
        $this->assertModelData($userStatus->toArray(), $dbUserStatus);
    }

    /**
     * @test update
     */
    public function test_update_user_status()
    {
        $userStatus = factory(UserStatus::class)->create();
        $fakeUserStatus = factory(UserStatus::class)->make()->toArray();

        $updatedUserStatus = $this->userStatusRepo->update($fakeUserStatus, $userStatus->id);

        $this->assertModelData($fakeUserStatus, $updatedUserStatus->toArray());
        $dbUserStatus = $this->userStatusRepo->find($userStatus->id);
        $this->assertModelData($fakeUserStatus, $dbUserStatus->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_user_status()
    {
        $userStatus = factory(UserStatus::class)->create();

        $resp = $this->userStatusRepo->delete($userStatus->id);

        $this->assertTrue($resp);
        $this->assertNull(UserStatus::find($userStatus->id), 'UserStatus should not exist in DB');
    }
}
