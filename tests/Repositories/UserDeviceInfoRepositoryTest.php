<?php namespace Tests\Repositories;

use App\Models\UserDeviceInfo;
use App\Repositories\Backend\UserDeviceInfoRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class UserDeviceInfoRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var UserDeviceInfoRepository
     */
    protected $userDeviceInfoRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->userDeviceInfoRepo = \App::make(UserDeviceInfoRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_user_device_info()
    {
        $userDeviceInfo = factory(UserDeviceInfo::class)->make()->toArray();

        $createdUserDeviceInfo = $this->userDeviceInfoRepo->create($userDeviceInfo);

        $createdUserDeviceInfo = $createdUserDeviceInfo->toArray();
        $this->assertArrayHasKey('id', $createdUserDeviceInfo);
        $this->assertNotNull($createdUserDeviceInfo['id'], 'Created UserDeviceInfo must have id specified');
        $this->assertNotNull(UserDeviceInfo::find($createdUserDeviceInfo['id']), 'UserDeviceInfo with given id must be in DB');
        $this->assertModelData($userDeviceInfo, $createdUserDeviceInfo);
    }

    /**
     * @test read
     */
    public function test_read_user_device_info()
    {
        $userDeviceInfo = factory(UserDeviceInfo::class)->create();

        $dbUserDeviceInfo = $this->userDeviceInfoRepo->find($userDeviceInfo->id);

        $dbUserDeviceInfo = $dbUserDeviceInfo->toArray();
        $this->assertModelData($userDeviceInfo->toArray(), $dbUserDeviceInfo);
    }

    /**
     * @test update
     */
    public function test_update_user_device_info()
    {
        $userDeviceInfo = factory(UserDeviceInfo::class)->create();
        $fakeUserDeviceInfo = factory(UserDeviceInfo::class)->make()->toArray();

        $updatedUserDeviceInfo = $this->userDeviceInfoRepo->update($fakeUserDeviceInfo, $userDeviceInfo->id);

        $this->assertModelData($fakeUserDeviceInfo, $updatedUserDeviceInfo->toArray());
        $dbUserDeviceInfo = $this->userDeviceInfoRepo->find($userDeviceInfo->id);
        $this->assertModelData($fakeUserDeviceInfo, $dbUserDeviceInfo->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_user_device_info()
    {
        $userDeviceInfo = factory(UserDeviceInfo::class)->create();

        $resp = $this->userDeviceInfoRepo->delete($userDeviceInfo->id);

        $this->assertTrue($resp);
        $this->assertNull(UserDeviceInfo::find($userDeviceInfo->id), 'UserDeviceInfo should not exist in DB');
    }
}
