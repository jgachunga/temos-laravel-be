<?php namespace Tests\Repositories;

use App\Models\FormsAnswered;
use App\Repositories\Backend\FormsAnsweredRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class FormsAnsweredRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var FormsAnsweredRepository
     */
    protected $formsAnsweredRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->formsAnsweredRepo = \App::make(FormsAnsweredRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_forms_answered()
    {
        $formsAnswered = factory(FormsAnswered::class)->make()->toArray();

        $createdFormsAnswered = $this->formsAnsweredRepo->create($formsAnswered);

        $createdFormsAnswered = $createdFormsAnswered->toArray();
        $this->assertArrayHasKey('id', $createdFormsAnswered);
        $this->assertNotNull($createdFormsAnswered['id'], 'Created FormsAnswered must have id specified');
        $this->assertNotNull(FormsAnswered::find($createdFormsAnswered['id']), 'FormsAnswered with given id must be in DB');
        $this->assertModelData($formsAnswered, $createdFormsAnswered);
    }

    /**
     * @test read
     */
    public function test_read_forms_answered()
    {
        $formsAnswered = factory(FormsAnswered::class)->create();

        $dbFormsAnswered = $this->formsAnsweredRepo->find($formsAnswered->id);

        $dbFormsAnswered = $dbFormsAnswered->toArray();
        $this->assertModelData($formsAnswered->toArray(), $dbFormsAnswered);
    }

    /**
     * @test update
     */
    public function test_update_forms_answered()
    {
        $formsAnswered = factory(FormsAnswered::class)->create();
        $fakeFormsAnswered = factory(FormsAnswered::class)->make()->toArray();

        $updatedFormsAnswered = $this->formsAnsweredRepo->update($fakeFormsAnswered, $formsAnswered->id);

        $this->assertModelData($fakeFormsAnswered, $updatedFormsAnswered->toArray());
        $dbFormsAnswered = $this->formsAnsweredRepo->find($formsAnswered->id);
        $this->assertModelData($fakeFormsAnswered, $dbFormsAnswered->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_forms_answered()
    {
        $formsAnswered = factory(FormsAnswered::class)->create();

        $resp = $this->formsAnsweredRepo->delete($formsAnswered->id);

        $this->assertTrue($resp);
        $this->assertNull(FormsAnswered::find($formsAnswered->id), 'FormsAnswered should not exist in DB');
    }
}
