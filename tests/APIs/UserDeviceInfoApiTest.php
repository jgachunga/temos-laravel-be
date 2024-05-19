<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\UserDeviceInfo;

class UserDeviceInfoApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_user_device_info()
    {
        $userDeviceInfo = factory(UserDeviceInfo::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/user_device_infos', $userDeviceInfo
        );

        $this->assertApiResponse($userDeviceInfo);
    }

    /**
     * @test
     */
    public function test_read_user_device_info()
    {
        $userDeviceInfo = factory(UserDeviceInfo::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/user_device_infos/'.$userDeviceInfo->id
        );

        $this->assertApiResponse($userDeviceInfo->toArray());
    }

    /**
     * @test
     */
    public function test_update_user_device_info()
    {
        $userDeviceInfo = factory(UserDeviceInfo::class)->create();
        $editedUserDeviceInfo = factory(UserDeviceInfo::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/user_device_infos/'.$userDeviceInfo->id,
            $editedUserDeviceInfo
        );

        $this->assertApiResponse($editedUserDeviceInfo);
    }

    /**
     * @test
     */
    public function test_delete_user_device_info()
    {
        $userDeviceInfo = factory(UserDeviceInfo::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/user_device_infos/'.$userDeviceInfo->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/user_device_infos/'.$userDeviceInfo->id
        );

        $this->response->assertStatus(404);
    }
}
