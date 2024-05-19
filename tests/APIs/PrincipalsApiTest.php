<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Principals;

class PrincipalsApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_principals()
    {
        $principals = factory(Principals::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/principals', $principals
        );

        $this->assertApiResponse($principals);
    }

    /**
     * @test
     */
    public function test_read_principals()
    {
        $principals = factory(Principals::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/principals/'.$principals->id
        );

        $this->assertApiResponse($principals->toArray());
    }

    /**
     * @test
     */
    public function test_update_principals()
    {
        $principals = factory(Principals::class)->create();
        $editedPrincipals = factory(Principals::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/principals/'.$principals->id,
            $editedPrincipals
        );

        $this->assertApiResponse($editedPrincipals);
    }

    /**
     * @test
     */
    public function test_delete_principals()
    {
        $principals = factory(Principals::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/principals/'.$principals->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/principals/'.$principals->id
        );

        $this->response->assertStatus(404);
    }
}
