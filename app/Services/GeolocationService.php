<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class GeolocationService
{
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('services.google_maps.api_key');
        $this->baseUrl = 'https://maps.googleapis.com/maps/api';
    }

    /**
     * Get coordinates from address
     */
    public function geocodeAddress(string $address): array
    {
        $cacheKey = 'geocode:' . md5($address);

        return Cache::remember($cacheKey, 3600, function () use ($address) {
            try {
                $response = Http::get($this->baseUrl . '/geocode/json', [
                    'address' => $address,
                    'key' => $this->apiKey,
                ]);

                if ($response->successful()) {
                    $data = $response->json();

                    if ($data['status'] === 'OK' && !empty($data['results'])) {
                        $location = $data['results'][0]['geometry']['location'];

                        return [
                            'success' => true,
                            'latitude' => $location['lat'],
                            'longitude' => $location['lng'],
                            'formatted_address' => $data['results'][0]['formatted_address']
                        ];
                    }
                }

                return [
                    'success' => false,
                    'error' => 'No se pudo obtener las coordenadas de la dirección'
                ];

            } catch (\Exception $e) {
                Log::error('Geocoding failed', [
                    'address' => $address,
                    'error' => $e->getMessage()
                ]);

                return [
                    'success' => false,
                    'error' => 'Error al obtener las coordenadas'
                ];
            }
        });
    }

    /**
     * Calculate distance between two points
     */
    public function calculateDistance(float $lat1, float $lon1, float $lat2, float $lon2): float
    {
        $earthRadius = 6371; // Earth's radius in kilometers

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat/2) * sin($dLat/2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($dLon/2) * sin($dLon/2);

        $c = 2 * atan2(sqrt($a), sqrt(1-$a));

        return $earthRadius * $c;
    }

    /**
     * Get nearby drivers
     */
    public function getNearbyDrivers(float $latitude, float $longitude, float $radius = 5): array
    {
        // This would typically query your database for nearby drivers
        // For now, we'll return a mock response
        return [
            'success' => true,
            'drivers' => [
                [
                    'id' => 1,
                    'name' => 'Juan Pérez',
                    'latitude' => $latitude + 0.01,
                    'longitude' => $longitude + 0.01,
                    'distance' => 1.2
                ],
                [
                    'id' => 2,
                    'name' => 'María García',
                    'latitude' => $latitude - 0.01,
                    'longitude' => $longitude + 0.02,
                    'distance' => 2.1
                ]
            ]
        ];
    }
}
