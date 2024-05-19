<?php namespace Tests\Repositories;

use App\Models\FormCategory;
use App\Repositories\Backend\FormCategoryRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class FormCategoryRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var FormCategoryRepository
     */
    protected $formCategoryRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->formCategoryRepo = \App::make(FormCategoryRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_form_category()
    {
        $formCategory = factory(FormCategory::class)->make()->toArray();

        $createdFormCategory = $this->formCategoryRepo->create($formCategory);

        $createdFormCategory = $createdFormCategory->toArray();
        $this->assertArrayHasKey('id', $createdFormCategory);
        $this->assertNotNull($createdFormCategory['id'], 'Created FormCategory must have id specified');
        $this->assertNotNull(FormCategory::find($createdFormCategory['id']), 'FormCategory with given id must be in DB');
        $this->assertModelData($formCategory, $createdFormCategory);
    }

    /**
     * @test read
     */
    public function test_read_form_category()
    {
        $formCategory = factory(FormCategory::class)->create();

        $dbFormCategory = $this->formCategoryRepo->find($formCategory->id);

        $dbFormCategory = $dbFormCategory->toArray();
        $this->assertModelData($formCategory->toArray(), $dbFormCategory);
    }

    /**
     * @test update
     */
    public function test_update_form_category()
    {
        $formCategory = factory(FormCategory::class)->create();
        $fakeFormCategory = factory(FormCategory::class)->make()->toArray();

        $updatedFormCategory = $this->formCategoryRepo->update($fakeFormCategory, $formCategory->id);

        $this->assertModelData($fakeFormCategory, $updatedFormCategory->toArray());
        $dbFormCategory = $this->formCategoryRepo->find($formCategory->id);
        $this->assertModelData($fakeFormCategory, $dbFormCategory->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_form_category()
    {
        $formCategory = factory(FormCategory::class)->create();

        $resp = $this->formCategoryRepo->delete($formCategory->id);

        $this->assertTrue($resp);
        $this->assertNull(FormCategory::find($formCategory->id), 'FormCategory should not exist in DB');
    }
}
