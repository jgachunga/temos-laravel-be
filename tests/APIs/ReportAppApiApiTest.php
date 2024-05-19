<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\ReportAppApi;

class ReportAppApiApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_report_app_api()
    {
        $reportAppApi = factory(ReportAppApi::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/report_app_apis', $reportAppApi
        );

        $this->assertApiResponse($reportAppApi);
    }

    /**
     * @test
     */
    public function test_read_report_app_api()
    {
        $reportAppApi = factory(ReportAppApi::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/report_app_apis/'.$reportAppApi->id
        );

        $this->assertApiResponse($reportAppApi->toArray());
    }

    /**
     * @test
     */
    public function test_update_report_app_api()
    {
        $reportAppApi = factory(ReportAppApi::class)->create();
        $editedReportAppApi = factory(ReportAppApi::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/report_app_apis/'.$reportAppApi->id,
            $editedReportAppApi
        );

        $this->assertApiResponse($editedReportAppApi);
    }

    /**
     * @test
     */
    public function test_delete_report_app_api()
    {
        $reportAppApi = factory(ReportAppApi::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/report_app_apis/'.$reportAppApi->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/report_app_apis/'.$reportAppApi->id
        );

        $this->response->assertStatus(404);
    }
}
