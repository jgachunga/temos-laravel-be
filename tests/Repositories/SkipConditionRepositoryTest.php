<?php namespace Tests\Repositories;

use App\Models\SkipCondition;
use App\Repositories\Backend\SkipConditionRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class SkipConditionRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var SkipConditionRepository
     */
    protected $skipConditionRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->skipConditionRepo = \App::make(SkipConditionRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_skip_condition()
    {
        $skipCondition = factory(SkipCondition::class)->make()->toArray();

        $createdSkipCondition = $this->skipConditionRepo->create($skipCondition);

        $createdSkipCondition = $createdSkipCondition->toArray();
        $this->assertArrayHasKey('id', $createdSkipCondition);
        $this->assertNotNull($createdSkipCondition['id'], 'Created SkipCondition must have id specified');
        $this->assertNotNull(SkipCondition::find($createdSkipCondition['id']), 'SkipCondition with given id must be in DB');
        $this->assertModelData($skipCondition, $createdSkipCondition);
    }

    /**
     * @test read
     */
    public function test_read_skip_condition()
    {
        $skipCondition = factory(SkipCondition::class)->create();

        $dbSkipCondition = $this->skipConditionRepo->find($skipCondition->id);

        $dbSkipCondition = $dbSkipCondition->toArray();
        $this->assertModelData($skipCondition->toArray(), $dbSkipCondition);
    }

    /**
     * @test update
     */
    public function test_update_skip_condition()
    {
        $skipCondition = factory(SkipCondition::class)->create();
        $fakeSkipCondition = factory(SkipCondition::class)->make()->toArray();

        $updatedSkipCondition = $this->skipConditionRepo->update($fakeSkipCondition, $skipCondition->id);

        $this->assertModelData($fakeSkipCondition, $updatedSkipCondition->toArray());
        $dbSkipCondition = $this->skipConditionRepo->find($skipCondition->id);
        $this->assertModelData($fakeSkipCondition, $dbSkipCondition->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_skip_condition()
    {
        $skipCondition = factory(SkipCondition::class)->create();

        $resp = $this->skipConditionRepo->delete($skipCondition->id);

        $this->assertTrue($resp);
        $this->assertNull(SkipCondition::find($skipCondition->id), 'SkipCondition should not exist in DB');
    }
}
