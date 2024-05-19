<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Sync;

class SyncApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_sync()
    {
        $sync = factory(Sync::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/syncs', $sync
        );

        $this->assertApiResponse($sync);
    }

    /**
     * @test
     */
    public function test_read_sync()
    {
        $sync = factory(Sync::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/syncs/'.$sync->id
        );

        $this->assertApiResponse($sync->toArray());
    }

    /**
     * @test
     */
    public function test_update_sync()
    {
        $sync = factory(Sync::class)->create();
        $editedSync = factory(Sync::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/syncs/'.$sync->id,
            $editedSync
        );

        $this->assertApiResponse($editedSync);
    }

    /**
     * @test
     */
    public function test_delete_sync()
    {
        $sync = factory(Sync::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/syncs/'.$sync->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/syncs/'.$sync->id
        );

        $this->response->assertStatus(404);
    }
}
