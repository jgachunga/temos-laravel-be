<?php namespace Tests\Repositories;

use App\Models\SkipOption;
use App\Repositories\Backend\SkipOptionRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class SkipOptionRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var SkipOptionRepository
     */
    protected $skipOptionRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->skipOptionRepo = \App::make(SkipOptionRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_skip_option()
    {
        $skipOption = factory(SkipOption::class)->make()->toArray();

        $createdSkipOption = $this->skipOptionRepo->create($skipOption);

        $createdSkipOption = $createdSkipOption->toArray();
        $this->assertArrayHasKey('id', $createdSkipOption);
        $this->assertNotNull($createdSkipOption['id'], 'Created SkipOption must have id specified');
        $this->assertNotNull(SkipOption::find($createdSkipOption['id']), 'SkipOption with given id must be in DB');
        $this->assertModelData($skipOption, $createdSkipOption);
    }

    /**
     * @test read
     */
    public function test_read_skip_option()
    {
        $skipOption = factory(SkipOption::class)->create();

        $dbSkipOption = $this->skipOptionRepo->find($skipOption->id);

        $dbSkipOption = $dbSkipOption->toArray();
        $this->assertModelData($skipOption->toArray(), $dbSkipOption);
    }

    /**
     * @test update
     */
    public function test_update_skip_option()
    {
        $skipOption = factory(SkipOption::class)->create();
        $fakeSkipOption = factory(SkipOption::class)->make()->toArray();

        $updatedSkipOption = $this->skipOptionRepo->update($fakeSkipOption, $skipOption->id);

        $this->assertModelData($fakeSkipOption, $updatedSkipOption->toArray());
        $dbSkipOption = $this->skipOptionRepo->find($skipOption->id);
        $this->assertModelData($fakeSkipOption, $dbSkipOption->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_skip_option()
    {
        $skipOption = factory(SkipOption::class)->create();

        $resp = $this->skipOptionRepo->delete($skipOption->id);

        $this->assertTrue($resp);
        $this->assertNull(SkipOption::find($skipOption->id), 'SkipOption should not exist in DB');
    }
}
