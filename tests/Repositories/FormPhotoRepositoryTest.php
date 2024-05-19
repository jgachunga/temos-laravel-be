<?php namespace Tests\Repositories;

use App\Models\FormPhoto;
use App\Repositories\Backend\FormPhotoRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class FormPhotoRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var FormPhotoRepository
     */
    protected $formPhotoRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->formPhotoRepo = \App::make(FormPhotoRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_form_photo()
    {
        $formPhoto = factory(FormPhoto::class)->make()->toArray();

        $createdFormPhoto = $this->formPhotoRepo->create($formPhoto);

        $createdFormPhoto = $createdFormPhoto->toArray();
        $this->assertArrayHasKey('id', $createdFormPhoto);
        $this->assertNotNull($createdFormPhoto['id'], 'Created FormPhoto must have id specified');
        $this->assertNotNull(FormPhoto::find($createdFormPhoto['id']), 'FormPhoto with given id must be in DB');
        $this->assertModelData($formPhoto, $createdFormPhoto);
    }

    /**
     * @test read
     */
    public function test_read_form_photo()
    {
        $formPhoto = factory(FormPhoto::class)->create();

        $dbFormPhoto = $this->formPhotoRepo->find($formPhoto->id);

        $dbFormPhoto = $dbFormPhoto->toArray();
        $this->assertModelData($formPhoto->toArray(), $dbFormPhoto);
    }

    /**
     * @test update
     */
    public function test_update_form_photo()
    {
        $formPhoto = factory(FormPhoto::class)->create();
        $fakeFormPhoto = factory(FormPhoto::class)->make()->toArray();

        $updatedFormPhoto = $this->formPhotoRepo->update($fakeFormPhoto, $formPhoto->id);

        $this->assertModelData($fakeFormPhoto, $updatedFormPhoto->toArray());
        $dbFormPhoto = $this->formPhotoRepo->find($formPhoto->id);
        $this->assertModelData($fakeFormPhoto, $dbFormPhoto->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_form_photo()
    {
        $formPhoto = factory(FormPhoto::class)->create();

        $resp = $this->formPhotoRepo->delete($formPhoto->id);

        $this->assertTrue($resp);
        $this->assertNull(FormPhoto::find($formPhoto->id), 'FormPhoto should not exist in DB');
    }
}
