<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class ExternalApiService
{
    protected $baseUrl;
    protected $apiKey;
    protected $timeout;

    public function __construct()
    {
        $this->baseUrl = config('services.external_api.base_url');
        $this->apiKey = config('services.external_api.key');
        $this->timeout = config('services.external_api.timeout', 30);
    }

    /**
     * Make authenticated request to external API
     */
    public function makeRequest(string $endpoint, array $data = [], string $method = 'GET'): array
    {
        try {
            $url = $this->baseUrl . $endpoint;

            $response = Http::timeout($this->timeout)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ])
                ->$method($url, $data);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'data' => $response->json(),
                    'status' => $response->status()
                ];
            }

            return [
                'success' => false,
                'error' => $response->body(),
                'status' => $response->status()
            ];

        } catch (\Exception $e) {
            Log::error('External API request failed', [
                'endpoint' => $endpoint,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return [
                'success' => false,
                'error' => 'Error de conexión con el servicio externo',
                'status' => 500
            ];
        }
    }

    /**
     * Get cached data or make request
     */
    public function getCachedData(string $endpoint, int $cacheMinutes = 60): array
    {
        $cacheKey = 'external_api:' . md5($endpoint);

        return Cache::remember($cacheKey, $cacheMinutes * 60, function () use ($endpoint) {
            return $this->makeRequest($endpoint);
        });
    }

    /**
     * Validate external API response
     */
    protected function validateResponse(array $response): bool
    {
        if (!$response['success']) {
            return false;
        }

        // Add custom validation logic here
        return isset($response['data']);
    }
}
