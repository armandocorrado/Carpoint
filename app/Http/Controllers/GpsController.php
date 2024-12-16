<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GpsController extends Controller
{
    public function reverseGeocode($latitude, $longitude)
    {
        $apiKey = 'pk.7d4e78ae5a5c04cd4e8e433f78feb68c';  \Log::info($apiKey);

        // URL dell'API LocationIQ
        $url = "https://us1.locationiq.com/v1/reverse.php?key={$apiKey}&lat={$latitude}&lon={$longitude}&format=json";

        try {
           // Effettua la chiamata HTTP ignorando la verifica SSL
           $response = Http::withoutVerifying()->get($url);

            if ($response->ok()) {
                $data = $response->json();

                // Estrai l'indirizzo leggibile
                $address = $data['display_name'] ?? 'Indirizzo non disponibile';

                return response()->json([
                    'success' => true,
                    'address' => $address,
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Errore nel reverse geocoding: risposta non valida.',
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Errore durante la richiesta al servizio di geocoding.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }    
}
