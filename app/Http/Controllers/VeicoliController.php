<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Trovata;
use App\Models\VeicoliManuali;

class VeicoliController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }


    public function addveicolo()
    {
    return view("aggiungi_veicolo");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        
    //------------------------------------------VALIDAZIONE---------------------------------------------------//    
                                                                                                             //*

        $validated = $request->validate([                                                                    //*
            'nuovo_usato' => 'required',                                                                     //*
            'targa' => 'required',                                                                           //*
            'telaio' => 'required',                                                                          //*
            'ubicazione' => 'required', 
            'marca' => 'required',
            'modello' => 'required',
            'colore' => 'required',
            'nota' => 'required',
        ]);
    
       

    //------------------------------------------FINE VALIDAZIONE------------------------------------------------//


        
       $nuovo_usato = $request->input('nuovo_usato');
       $targa = $request->input('targa');
       $telaio = $request->input('telaio');
       $ubicazione = $request->input('ubicazione');
       $marca = $request->input('marca');
       $modello = $request->input('modello');
       $colore = $request->input('colore');
       $nota = $request->input('nota');



       
       $targa_veicolo = VeicoliManuali::where('targa', $targa)->select('targa', 'telaio', 'nuovo_usato')->first();
       $telaio_veicolo = VeicoliManuali::where('telaio', $telaio)->select('targa', 'telaio', 'nuovo_usato')->first();

       
        //Controllo che la targa non si agia presente nella tabella
    if($targa_veicolo && !$telaio_veicolo){
        
       return redirect('ricerca-veicoli')->with('status', 'Errore: un veicolo con la targa: '.$targa. ' esiste già' )->with('targa', $targa);

    }elseif($telaio_veicolo && !$targa_veicolo){

            
        return redirect('ricerca-veicoli')->with('status', 'Errore: un veicolo con il telaio: '.$telaio. ' esiste già')->with('telaio', $telaio);


    }elseif($telaio_veicolo == true && $targa_veicolo == true && $telaio_veicolo->nuovo_usato == $targa_veicolo->nuovo_usato){

            
        return redirect('ricerca-veicoli')->with('status', 'Errore: un veicolo con la targa '.$targa.' e il telaio '.$telaio.' esiste già')->with(['telaio' => $telaio, 'targa'=> $targa ]);

    }elseif($telaio_veicolo == true && $targa_veicolo == true && $telaio_veicolo->nuovo_usato != $targa_veicolo->nuovo_usato){


    return redirect('ricerca-veicoli')->with('status', 'Errore: due veicoli con la targa '.$targa.' e il telaio '.$telaio.' esistono già')->with(['telaio' => $telaio, 'targa'=> $targa ]);

    }else{



      $veicolo_manuale =   VeicoliManuali::create([
        
             'nuovo_usato' => $nuovo_usato,
             'status'=> 'M',
             'telaio'=> $telaio,
             'targa'=> $targa,
             'ubicazione'=> $ubicazione,
             'marca'=> $marca,
             'modello'=> $modello,
             'colore'=> $colore,
             'nota'=> $nota,



        ]);

       

        
        //inserisco nell'inventario 
        $nuovo_usato_trovata = "";
        if($veicolo_manuale->nuovo_usato == 'n'){ 
            $nuovo_usato_trovata = "mn";  
        }else{ 
            $nuovo_usato_trovata = "mu"; 
        }

        Trovata::create([

            'nuovo_usato' => $nuovo_usato_trovata,
            'idveicolo' => $veicolo_manuale->id,
            'trovata' => 1,
            'id_operatore' => Auth::user()->id,
            'user_operatore' => Auth::user()->name,
            'dataOra' => now(),
            'luogo' => $veicolo_manuale->ubicazione,
            
        ]);





    }

           return back()->with('status', 'veicolo aggiunto correattamente');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
