<?php namespace Tests\Repositories;

use App\Models\ReportAppApi;
use App\Repositories\Backend\ReportAppApiRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class ReportAppApiRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var ReportAppApiRepository
     */
    protected $reportAppApiRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->reportAppApiRepo = \App::make(ReportAppApiRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_report_app_api()
    {
        $reportAppApi = factory(ReportAppApi::class)->make()->toArray();

        $createdReportAppApi = $this->reportAppApiRepo->create($reportAppApi);

        $createdReportAppApi = $createdReportAppApi->toArray();
        $this->assertArrayHasKey('id', $createdReportAppApi);
        $this->assertNotNull($createdReportAppApi['id'], 'Created ReportAppApi must have id specified');
        $this->assertNotNull(ReportAppApi::find($createdReportAppApi['id']), 'ReportAppApi with given id must be in DB');
        $this->assertModelData($reportAppApi, $createdReportAppApi);
    }

    /**
     * @test read
     */
    public function test_read_report_app_api()
    {
        $reportAppApi = factory(ReportAppApi::class)->create();

        $dbReportAppApi = $this->reportAppApiRepo->find($reportAppApi->id);

        $dbReportAppApi = $dbReportAppApi->toArray();
        $this->assertModelData($reportAppApi->toArray(), $dbReportAppApi);
    }

    /**
     * @test update
     */
    public function test_update_report_app_api()
    {
        $reportAppApi = factory(ReportAppApi::class)->create();
        $fakeReportAppApi = factory(ReportAppApi::class)->make()->toArray();

        $updatedReportAppApi = $this->reportAppApiRepo->update($fakeReportAppApi, $reportAppApi->id);

        $this->assertModelData($fakeReportAppApi, $updatedReportAppApi->toArray());
        $dbReportAppApi = $this->reportAppApiRepo->find($reportAppApi->id);
        $this->assertModelData($fakeReportAppApi, $dbReportAppApi->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_report_app_api()
    {
        $reportAppApi = factory(ReportAppApi::class)->create();

        $resp = $this->reportAppApiRepo->delete($reportAppApi->id);

        $this->assertTrue($resp);
        $this->assertNull(ReportAppApi::find($reportAppApi->id), 'ReportAppApi should not exist in DB');
    }
}
