<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\SkipCondition;

class SkipConditionApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_skip_condition()
    {
        $skipCondition = factory(SkipCondition::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/skip_conditions', $skipCondition
        );

        $this->assertApiResponse($skipCondition);
    }

    /**
     * @test
     */
    public function test_read_skip_condition()
    {
        $skipCondition = factory(SkipCondition::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/skip_conditions/'.$skipCondition->id
        );

        $this->assertApiResponse($skipCondition->toArray());
    }

    /**
     * @test
     */
    public function test_update_skip_condition()
    {
        $skipCondition = factory(SkipCondition::class)->create();
        $editedSkipCondition = factory(SkipCondition::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/skip_conditions/'.$skipCondition->id,
            $editedSkipCondition
        );

        $this->assertApiResponse($editedSkipCondition);
    }

    /**
     * @test
     */
    public function test_delete_skip_condition()
    {
        $skipCondition = factory(SkipCondition::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/skip_conditions/'.$skipCondition->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/skip_conditions/'.$skipCondition->id
        );

        $this->response->assertStatus(404);
    }
}
