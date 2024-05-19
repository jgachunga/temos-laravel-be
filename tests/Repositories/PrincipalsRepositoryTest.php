<?php namespace Tests\Repositories;

use App\Models\Principals;
use App\Repositories\Backend\PrincipalsRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class PrincipalsRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var PrincipalsRepository
     */
    protected $principalsRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->principalsRepo = \App::make(PrincipalsRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_principals()
    {
        $principals = factory(Principals::class)->make()->toArray();

        $createdPrincipals = $this->principalsRepo->create($principals);

        $createdPrincipals = $createdPrincipals->toArray();
        $this->assertArrayHasKey('id', $createdPrincipals);
        $this->assertNotNull($createdPrincipals['id'], 'Created Principals must have id specified');
        $this->assertNotNull(Principals::find($createdPrincipals['id']), 'Principals with given id must be in DB');
        $this->assertModelData($principals, $createdPrincipals);
    }

    /**
     * @test read
     */
    public function test_read_principals()
    {
        $principals = factory(Principals::class)->create();

        $dbPrincipals = $this->principalsRepo->find($principals->id);

        $dbPrincipals = $dbPrincipals->toArray();
        $this->assertModelData($principals->toArray(), $dbPrincipals);
    }

    /**
     * @test update
     */
    public function test_update_principals()
    {
        $principals = factory(Principals::class)->create();
        $fakePrincipals = factory(Principals::class)->make()->toArray();

        $updatedPrincipals = $this->principalsRepo->update($fakePrincipals, $principals->id);

        $this->assertModelData($fakePrincipals, $updatedPrincipals->toArray());
        $dbPrincipals = $this->principalsRepo->find($principals->id);
        $this->assertModelData($fakePrincipals, $dbPrincipals->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_principals()
    {
        $principals = factory(Principals::class)->create();

        $resp = $this->principalsRepo->delete($principals->id);

        $this->assertTrue($resp);
        $this->assertNull(Principals::find($principals->id), 'Principals should not exist in DB');
    }
}
