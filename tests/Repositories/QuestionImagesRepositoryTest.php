<?php namespace Tests\Repositories;

use App\Models\QuestionImages;
use App\Repositories\Backend\QuestionImagesRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class QuestionImagesRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var QuestionImagesRepository
     */
    protected $questionImagesRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->questionImagesRepo = \App::make(QuestionImagesRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_question_images()
    {
        $questionImages = factory(QuestionImages::class)->make()->toArray();

        $createdQuestionImages = $this->questionImagesRepo->create($questionImages);

        $createdQuestionImages = $createdQuestionImages->toArray();
        $this->assertArrayHasKey('id', $createdQuestionImages);
        $this->assertNotNull($createdQuestionImages['id'], 'Created QuestionImages must have id specified');
        $this->assertNotNull(QuestionImages::find($createdQuestionImages['id']), 'QuestionImages with given id must be in DB');
        $this->assertModelData($questionImages, $createdQuestionImages);
    }

    /**
     * @test read
     */
    public function test_read_question_images()
    {
        $questionImages = factory(QuestionImages::class)->create();

        $dbQuestionImages = $this->questionImagesRepo->find($questionImages->id);

        $dbQuestionImages = $dbQuestionImages->toArray();
        $this->assertModelData($questionImages->toArray(), $dbQuestionImages);
    }

    /**
     * @test update
     */
    public function test_update_question_images()
    {
        $questionImages = factory(QuestionImages::class)->create();
        $fakeQuestionImages = factory(QuestionImages::class)->make()->toArray();

        $updatedQuestionImages = $this->questionImagesRepo->update($fakeQuestionImages, $questionImages->id);

        $this->assertModelData($fakeQuestionImages, $updatedQuestionImages->toArray());
        $dbQuestionImages = $this->questionImagesRepo->find($questionImages->id);
        $this->assertModelData($fakeQuestionImages, $dbQuestionImages->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_question_images()
    {
        $questionImages = factory(QuestionImages::class)->create();

        $resp = $this->questionImagesRepo->delete($questionImages->id);

        $this->assertTrue($resp);
        $this->assertNull(QuestionImages::find($questionImages->id), 'QuestionImages should not exist in DB');
    }
}
