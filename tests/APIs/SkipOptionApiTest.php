<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\SkipOption;

class SkipOptionApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_skip_option()
    {
        $skipOption = factory(SkipOption::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/skip_options', $skipOption
        );

        $this->assertApiResponse($skipOption);
    }

    /**
     * @test
     */
    public function test_read_skip_option()
    {
        $skipOption = factory(SkipOption::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/skip_options/'.$skipOption->id
        );

        $this->assertApiResponse($skipOption->toArray());
    }

    /**
     * @test
     */
    public function test_update_skip_option()
    {
        $skipOption = factory(SkipOption::class)->create();
        $editedSkipOption = factory(SkipOption::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/skip_options/'.$skipOption->id,
            $editedSkipOption
        );

        $this->assertApiResponse($editedSkipOption);
    }

    /**
     * @test
     */
    public function test_delete_skip_option()
    {
        $skipOption = factory(SkipOption::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/skip_options/'.$skipOption->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/skip_options/'.$skipOption->id
        );

        $this->response->assertStatus(404);
    }
}
