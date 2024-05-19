<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\ClockTypes;

class ClockTypesApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_clock_types()
    {
        $clockTypes = factory(ClockTypes::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/clock_types', $clockTypes
        );

        $this->assertApiResponse($clockTypes);
    }

    /**
     * @test
     */
    public function test_read_clock_types()
    {
        $clockTypes = factory(ClockTypes::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/clock_types/'.$clockTypes->id
        );

        $this->assertApiResponse($clockTypes->toArray());
    }

    /**
     * @test
     */
    public function test_update_clock_types()
    {
        $clockTypes = factory(ClockTypes::class)->create();
        $editedClockTypes = factory(ClockTypes::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/clock_types/'.$clockTypes->id,
            $editedClockTypes
        );

        $this->assertApiResponse($editedClockTypes);
    }

    /**
     * @test
     */
    public function test_delete_clock_types()
    {
        $clockTypes = factory(ClockTypes::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/clock_types/'.$clockTypes->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/clock_types/'.$clockTypes->id
        );

        $this->response->assertStatus(404);
    }
}
