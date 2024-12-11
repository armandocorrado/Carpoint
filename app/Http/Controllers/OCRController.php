<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use thiagoalessio\TesseractOCR\TesseractOCR;
use Intervention\Image\Laravel\Facades\Image;
use Alimranahmed\LaraOCR\Facades\OCR;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;




class OCRController extends Controller

{

    public function extractText(Request $request)
    {
        // Assicurati che l'immagine sia presente nella richiesta
    $imageData = $request->input('image');

    if (empty($imageData)) {
        return response()->json(['error' => 'No image data received'], 400);
    }

    // Decodifica l'immagine base64
    $imageData = str_replace('data:image/jpeg;base64,', '', $imageData);
    $imageData = base64_decode($imageData);

    // Crea un file temporaneo per salvare l'immagine
    $tempPath = storage_path('app/temp_image.jpg');
   
    $file = file_put_contents($tempPath, $imageData);


    // Esegui l'OCR
    try {
        $text = \OCR::scan($tempPath, '--psm 6');
        return response()->json(['text' => $text]);
    } catch (\Exception $e) {
        return response()->json(['error' => 'OCR failed: ' . $e->getMessage()], 500);
    }

}





}