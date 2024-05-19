<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\UserDeviceImei;

class UserDeviceImeiApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_user_device_imei()
    {
        $userDeviceImei = factory(UserDeviceImei::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/user_device_imeis', $userDeviceImei
        );

        $this->assertApiResponse($userDeviceImei);
    }

    /**
     * @test
     */
    public function test_read_user_device_imei()
    {
        $userDeviceImei = factory(UserDeviceImei::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/user_device_imeis/'.$userDeviceImei->id
        );

        $this->assertApiResponse($userDeviceImei->toArray());
    }

    /**
     * @test
     */
    public function test_update_user_device_imei()
    {
        $userDeviceImei = factory(UserDeviceImei::class)->create();
        $editedUserDeviceImei = factory(UserDeviceImei::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/user_device_imeis/'.$userDeviceImei->id,
            $editedUserDeviceImei
        );

        $this->assertApiResponse($editedUserDeviceImei);
    }

    /**
     * @test
     */
    public function test_delete_user_device_imei()
    {
        $userDeviceImei = factory(UserDeviceImei::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/user_device_imeis/'.$userDeviceImei->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/user_device_imeis/'.$userDeviceImei->id
        );

        $this->response->assertStatus(404);
    }
}
