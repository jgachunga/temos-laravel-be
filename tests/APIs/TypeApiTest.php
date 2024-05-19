<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Type;

class TypeApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_type()
    {
        $type = factory(Type::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/types', $type
        );

        $this->assertApiResponse($type);
    }

    /**
     * @test
     */
    public function test_read_type()
    {
        $type = factory(Type::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/types/'.$type->id
        );

        $this->assertApiResponse($type->toArray());
    }

    /**
     * @test
     */
    public function test_update_type()
    {
        $type = factory(Type::class)->create();
        $editedType = factory(Type::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/types/'.$type->id,
            $editedType
        );

        $this->assertApiResponse($editedType);
    }

    /**
     * @test
     */
    public function test_delete_type()
    {
        $type = factory(Type::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/types/'.$type->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/types/'.$type->id
        );

        $this->response->assertStatus(404);
    }
}
