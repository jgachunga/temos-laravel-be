<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\ClockIn;

class ClockInApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_clock_in()
    {
        $clockIn = factory(ClockIn::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/clock_ins', $clockIn
        );

        $this->assertApiResponse($clockIn);
    }

    /**
     * @test
     */
    public function test_read_clock_in()
    {
        $clockIn = factory(ClockIn::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/clock_ins/'.$clockIn->id
        );

        $this->assertApiResponse($clockIn->toArray());
    }

    /**
     * @test
     */
    public function test_update_clock_in()
    {
        $clockIn = factory(ClockIn::class)->create();
        $editedClockIn = factory(ClockIn::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/clock_ins/'.$clockIn->id,
            $editedClockIn
        );

        $this->assertApiResponse($editedClockIn);
    }

    /**
     * @test
     */
    public function test_delete_clock_in()
    {
        $clockIn = factory(ClockIn::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/clock_ins/'.$clockIn->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/clock_ins/'.$clockIn->id
        );

        $this->response->assertStatus(404);
    }
}
