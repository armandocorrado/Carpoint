<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Home;
use App\Models\VeicoliNuovi;
use App\Models\VeicoliUsati;
use App\Models\Trovata;
use App\Models\VeicoliManuali;

class RicercaVeicoliController extends Controller
{
    

    public function search()
    {


    return view("ricerca-veicoli.ricerca_veicoli");
    }


    public function getData(Request $request)
    {
        $targa = $request->input('targa');
        $telaio = $request->input('telaio'); 
        $car = "";
        $trovata="";


        $operatore = Auth::user()->name;
        $ubicazione = Auth::user()->ubicazione;
        $dateNow = Carbon::now()->format('Y-m-d H:i:s');




        if($targa != "" && $telaio == "" ){
          $car = VeicoliNuovi::where('targa', 'like',  $targa.'%')
          ->where('status', '<>', 'U')
          ->first();



        }elseif($targa == "" && $telaio != "" ){
            $car = VeicoliNuovi::where('telaio', 'like',  $telaio.'%')
          ->where('status', '<>', 'U')
          ->first();

        }elseif($targa != "" && $telaio != ""){
            $car = VeicoliNuovi::where('targa', 'like',  $targa.'%')
            ->where('telaio', 'like',  $telaio.'%')
            ->where('status', '<>', 'U')
            ->first();
        }




       // Cerco nei veicoli usati

        if ($car == ""){
            if($targa != "" && $telaio == "" ){
                $car = VeicoliUsati::where('targa', 'like',  $targa.'%')
                ->where('status_veicolo', '<>', 'U')
                ->first();

        }elseif($targa == "" && $telaio != "" ){
            $car = VeicoliUsati::where('vin', 'like',  $telaio.'%')
          ->where('status_veicolo', '<>', 'U')
          ->first();

        }elseif($targa != "" && $telaio != ""){
            $car = VeicoliUsati::where('targa', 'like',  $targa.'%')
            ->where('vin', 'like',  $telaio.'%')
            ->where('status_veicolo', '<>', 'U')
            ->first();
        }
    }


     // Cerco nei veicoli manuali

     if ($car == ""){
        if($targa != "" && $telaio == "" ){
            $car = VeicoliManuali::where('targa', 'like',  $targa.'%')
            ->whereIn('nuovo_usato', ['n', 'u'])
            ->first();

    }elseif($targa == "" && $telaio != "" ){
        $car = VeicoliManuali::where('telaio', 'like',  $telaio.'%')
      ->whereIn('nuovo_usato', ['n', 'u'])
      ->first();


    }elseif($targa != "" && $telaio != ""){
        $car = VeicoliManuali::where('targa', 'like',  $targa.'%')
        ->where('telaio', 'like',  $telaio.'%')
        ->whereIn('nuovo_usato', ['n', 'u'])
        ->first();
    }
}



     
     $trovata =    Trovata::whereIdveicolo($car->id_veicolo)->orWhere('idveicolo', $car->id)->whereIn('nuovo_usato', ['n', 'u', 'mu', 'mn'])->first();



     if($trovata == null){ 

        $test = ['invent'=> "No"]; 
    
    }else{
        
        $test = ['invent'=> "Si"];
    
    }



     return response()->json(['car'=> $car, 'test'=> $test, 'trovata'=> $trovata, 'ubicazione'=> $ubicazione, 'operatore'=> $operatore, 'dateNow'=> $dateNow]);
    }

}
