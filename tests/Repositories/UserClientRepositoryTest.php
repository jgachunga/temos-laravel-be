<?php namespace Tests\Repositories;

use App\Models\UserClient;
use App\Repositories\Backend\UserClientRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class UserClientRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var UserClientRepository
     */
    protected $userClientRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->userClientRepo = \App::make(UserClientRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_user_client()
    {
        $userClient = factory(UserClient::class)->make()->toArray();

        $createdUserClient = $this->userClientRepo->create($userClient);

        $createdUserClient = $createdUserClient->toArray();
        $this->assertArrayHasKey('id', $createdUserClient);
        $this->assertNotNull($createdUserClient['id'], 'Created UserClient must have id specified');
        $this->assertNotNull(UserClient::find($createdUserClient['id']), 'UserClient with given id must be in DB');
        $this->assertModelData($userClient, $createdUserClient);
    }

    /**
     * @test read
     */
    public function test_read_user_client()
    {
        $userClient = factory(UserClient::class)->create();

        $dbUserClient = $this->userClientRepo->find($userClient->id);

        $dbUserClient = $dbUserClient->toArray();
        $this->assertModelData($userClient->toArray(), $dbUserClient);
    }

    /**
     * @test update
     */
    public function test_update_user_client()
    {
        $userClient = factory(UserClient::class)->create();
        $fakeUserClient = factory(UserClient::class)->make()->toArray();

        $updatedUserClient = $this->userClientRepo->update($fakeUserClient, $userClient->id);

        $this->assertModelData($fakeUserClient, $updatedUserClient->toArray());
        $dbUserClient = $this->userClientRepo->find($userClient->id);
        $this->assertModelData($fakeUserClient, $dbUserClient->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_user_client()
    {
        $userClient = factory(UserClient::class)->create();

        $resp = $this->userClientRepo->delete($userClient->id);

        $this->assertTrue($resp);
        $this->assertNull(UserClient::find($userClient->id), 'UserClient should not exist in DB');
    }
}
