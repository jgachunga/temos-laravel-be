<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Version;

class VersionApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_version()
    {
        $version = factory(Version::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/versions', $version
        );

        $this->assertApiResponse($version);
    }

    /**
     * @test
     */
    public function test_read_version()
    {
        $version = factory(Version::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/versions/'.$version->id
        );

        $this->assertApiResponse($version->toArray());
    }

    /**
     * @test
     */
    public function test_update_version()
    {
        $version = factory(Version::class)->create();
        $editedVersion = factory(Version::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/versions/'.$version->id,
            $editedVersion
        );

        $this->assertApiResponse($editedVersion);
    }

    /**
     * @test
     */
    public function test_delete_version()
    {
        $version = factory(Version::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/versions/'.$version->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/versions/'.$version->id
        );

        $this->response->assertStatus(404);
    }
}
