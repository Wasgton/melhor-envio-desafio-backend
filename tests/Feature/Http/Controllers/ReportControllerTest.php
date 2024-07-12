<?php

namespace Tests\Feature\Http\Controllers;

use App\Actions\Export\GenerateConsumerRequestReport;
use App\Actions\Export\GenerateLatenciesRequestReport;
use App\Actions\Export\GenerateServiceRequestReport;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ReportControllerTest extends TestCase
{
    public function test_should_export_consumer_requests_success()
    {      
        $response = $this->get('api/v1/report/consumer');
        $response->assertDownload();
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_should_export_service_requests_success()
    {
        $response = $this->get('api/v1/report/service');
        $response->assertStatus(Response::HTTP_OK);
        $response->assertDownload();
    }

    public function test_should_export_average_time_per_service_success()
    {
        $response = $this->get('api/v1/report/latency');
        $response->assertStatus(Response::HTTP_OK);
        $response->assertDownload();
    }

    public function test_should_not_export_consumer_requests()
    {
        $this->mock(GenerateConsumerRequestReport::class, function ($mock) {
            $mock->shouldReceive('execute')
                ->once()
                ->andThrow(new \Exception('Error generating report'));
        });
        $response = $this->get('api/v1/report/consumer');
        $response->assertStatus(Response::HTTP_INTERNAL_SERVER_ERROR);
        $response->assertJson(['error' => 'Failed to export consumer requests.']);
    }

    public function test_should_not_export_service_requests()
    {
        $this->mock(GenerateServiceRequestReport::class, function ($mock) {
            $mock->shouldReceive('execute')
                ->once()
                ->andThrow(new \Exception('Error generating report'));
        });
        $response = $this->get('api/v1/report/service');
        $response->assertStatus(Response::HTTP_INTERNAL_SERVER_ERROR);
        $response->assertJson(['error' => 'Failed to export service requests.']);
    }

    public function test_should_not_export_latency_requests()
    {
        $this->mock(GenerateLatenciesRequestReport::class, function ($mock) {
            $mock->shouldReceive('execute')
                ->once()
                ->andThrow(new \Exception('Error generating report'));
        });
        $response = $this->get('api/v1/report/latency');
        $response->assertStatus(Response::HTTP_INTERNAL_SERVER_ERROR);
        $response->assertJson(['error' => 'Failed to export average time per service.']);
    }
}