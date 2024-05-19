<?php namespace Tests\Repositories;

use App\Models\Version;
use App\Repositories\Backend\VersionRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class VersionRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var VersionRepository
     */
    protected $versionRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->versionRepo = \App::make(VersionRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_version()
    {
        $version = factory(Version::class)->make()->toArray();

        $createdVersion = $this->versionRepo->create($version);

        $createdVersion = $createdVersion->toArray();
        $this->assertArrayHasKey('id', $createdVersion);
        $this->assertNotNull($createdVersion['id'], 'Created Version must have id specified');
        $this->assertNotNull(Version::find($createdVersion['id']), 'Version with given id must be in DB');
        $this->assertModelData($version, $createdVersion);
    }

    /**
     * @test read
     */
    public function test_read_version()
    {
        $version = factory(Version::class)->create();

        $dbVersion = $this->versionRepo->find($version->id);

        $dbVersion = $dbVersion->toArray();
        $this->assertModelData($version->toArray(), $dbVersion);
    }

    /**
     * @test update
     */
    public function test_update_version()
    {
        $version = factory(Version::class)->create();
        $fakeVersion = factory(Version::class)->make()->toArray();

        $updatedVersion = $this->versionRepo->update($fakeVersion, $version->id);

        $this->assertModelData($fakeVersion, $updatedVersion->toArray());
        $dbVersion = $this->versionRepo->find($version->id);
        $this->assertModelData($fakeVersion, $dbVersion->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_version()
    {
        $version = factory(Version::class)->create();

        $resp = $this->versionRepo->delete($version->id);

        $this->assertTrue($resp);
        $this->assertNull(Version::find($version->id), 'Version should not exist in DB');
    }
}
