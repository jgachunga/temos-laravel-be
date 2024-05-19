<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Town;

class TownApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_town()
    {
        $town = factory(Town::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/towns', $town
        );

        $this->assertApiResponse($town);
    }

    /**
     * @test
     */
    public function test_read_town()
    {
        $town = factory(Town::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/towns/'.$town->id
        );

        $this->assertApiResponse($town->toArray());
    }

    /**
     * @test
     */
    public function test_update_town()
    {
        $town = factory(Town::class)->create();
        $editedTown = factory(Town::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/towns/'.$town->id,
            $editedTown
        );

        $this->assertApiResponse($editedTown);
    }

    /**
     * @test
     */
    public function test_delete_town()
    {
        $town = factory(Town::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/towns/'.$town->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/towns/'.$town->id
        );

        $this->response->assertStatus(404);
    }
}
