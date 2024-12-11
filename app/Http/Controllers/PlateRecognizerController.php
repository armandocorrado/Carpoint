<?php

namespace App\Http\Controllers;

use App\Services\PlateRecognizerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PlateRecognizerController extends Controller
{
    protected $plateRecognizer;

    public function __construct(PlateRecognizerService $plateRecognizer)
    {
        $this->plateRecognizer = $plateRecognizer;
    }

    public function recognize(Request $request, PlateRecognizerService $plateRecognizerService)
    {
        // Validazione input
        $request->validate([
            'image' => 'required|string',
        ]);

        // Decodifica immagine base64
        $imageData = $request->input('image');
        $imageData = str_replace('data:image/jpeg;base64,', '', $imageData);
        $imageData = str_replace(' ', '+', $imageData);

        // Salva immagine temporanea
        $imagePath = storage_path('app/public/temp_image.jpg');
        file_put_contents($imagePath, base64_decode($imageData));

        // Invoca il servizio Plate Recognizer
        $result = $plateRecognizerService->recognizePlate($imagePath);

        // Cancella immagine temporanea
        @unlink($imagePath);

        return response()->json($result);
    }
}
