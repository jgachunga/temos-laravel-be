<?php namespace Tests\Repositories;

use App\Models\UserDeviceImei;
use App\Repositories\Backend\UserDeviceImeiRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class UserDeviceImeiRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var UserDeviceImeiRepository
     */
    protected $userDeviceImeiRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->userDeviceImeiRepo = \App::make(UserDeviceImeiRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_user_device_imei()
    {
        $userDeviceImei = factory(UserDeviceImei::class)->make()->toArray();

        $createdUserDeviceImei = $this->userDeviceImeiRepo->create($userDeviceImei);

        $createdUserDeviceImei = $createdUserDeviceImei->toArray();
        $this->assertArrayHasKey('id', $createdUserDeviceImei);
        $this->assertNotNull($createdUserDeviceImei['id'], 'Created UserDeviceImei must have id specified');
        $this->assertNotNull(UserDeviceImei::find($createdUserDeviceImei['id']), 'UserDeviceImei with given id must be in DB');
        $this->assertModelData($userDeviceImei, $createdUserDeviceImei);
    }

    /**
     * @test read
     */
    public function test_read_user_device_imei()
    {
        $userDeviceImei = factory(UserDeviceImei::class)->create();

        $dbUserDeviceImei = $this->userDeviceImeiRepo->find($userDeviceImei->id);

        $dbUserDeviceImei = $dbUserDeviceImei->toArray();
        $this->assertModelData($userDeviceImei->toArray(), $dbUserDeviceImei);
    }

    /**
     * @test update
     */
    public function test_update_user_device_imei()
    {
        $userDeviceImei = factory(UserDeviceImei::class)->create();
        $fakeUserDeviceImei = factory(UserDeviceImei::class)->make()->toArray();

        $updatedUserDeviceImei = $this->userDeviceImeiRepo->update($fakeUserDeviceImei, $userDeviceImei->id);

        $this->assertModelData($fakeUserDeviceImei, $updatedUserDeviceImei->toArray());
        $dbUserDeviceImei = $this->userDeviceImeiRepo->find($userDeviceImei->id);
        $this->assertModelData($fakeUserDeviceImei, $dbUserDeviceImei->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_user_device_imei()
    {
        $userDeviceImei = factory(UserDeviceImei::class)->create();

        $resp = $this->userDeviceImeiRepo->delete($userDeviceImei->id);

        $this->assertTrue($resp);
        $this->assertNull(UserDeviceImei::find($userDeviceImei->id), 'UserDeviceImei should not exist in DB');
    }
}
