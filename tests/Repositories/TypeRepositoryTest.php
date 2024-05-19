<?php namespace Tests\Repositories;

use App\Models\Type;
use App\Repositories\Backend\TypeRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class TypeRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var TypeRepository
     */
    protected $typeRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->typeRepo = \App::make(TypeRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_type()
    {
        $type = factory(Type::class)->make()->toArray();

        $createdType = $this->typeRepo->create($type);

        $createdType = $createdType->toArray();
        $this->assertArrayHasKey('id', $createdType);
        $this->assertNotNull($createdType['id'], 'Created Type must have id specified');
        $this->assertNotNull(Type::find($createdType['id']), 'Type with given id must be in DB');
        $this->assertModelData($type, $createdType);
    }

    /**
     * @test read
     */
    public function test_read_type()
    {
        $type = factory(Type::class)->create();

        $dbType = $this->typeRepo->find($type->id);

        $dbType = $dbType->toArray();
        $this->assertModelData($type->toArray(), $dbType);
    }

    /**
     * @test update
     */
    public function test_update_type()
    {
        $type = factory(Type::class)->create();
        $fakeType = factory(Type::class)->make()->toArray();

        $updatedType = $this->typeRepo->update($fakeType, $type->id);

        $this->assertModelData($fakeType, $updatedType->toArray());
        $dbType = $this->typeRepo->find($type->id);
        $this->assertModelData($fakeType, $dbType->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_type()
    {
        $type = factory(Type::class)->create();

        $resp = $this->typeRepo->delete($type->id);

        $this->assertTrue($resp);
        $this->assertNull(Type::find($type->id), 'Type should not exist in DB');
    }
}
