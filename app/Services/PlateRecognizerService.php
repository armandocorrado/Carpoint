<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PlateRecognizerService
{
    protected $apiUrl;
    protected $apiKey;

    public function __construct()
    {
        $this->apiUrl = config('plate_recognizer.api_url');
        $this->apiKey = config('plate_recognizer.api_key');
    }

    public function recognizePlate($imagePath)
    {
        $response = Http::withOptions([
            'verify' => false, // Disabilita verifica SSL
        ])->withHeaders([
            'Authorization' => 'Token ' . $this->apiKey,
        ])->attach(
            'upload', file_get_contents($imagePath), basename($imagePath)
        )->post($this->apiUrl);

        if ($response->successful()) {
            return $response->json();
        }

        return ['error' => $response->body()];
    }
}

