<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Storage;
use App\Models\Trovata;
use App\Models\VeicoliManuali;
use App\Models\VeicoliImmagini;

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
//     public function store(Request $request)
//     {


        
//     //------------------------------------------VALIDAZIONE---------------------------------------------------//    
//                                                                                                              //*

//         $validated = $request->validate([                                                                    //*
//             'marca' => 'required',
//             'modello' => 'required',
//             'nota' => 'required',
//         ]);
    
       

//     //------------------------------------------FINE VALIDAZIONE------------------------------------------------//


        
//        $nuovo_usato = $request->input('nuovo_usato');
//        $targa = $request->input('targa');
//        $telaio = $request->input('telaio');
//        $ubicazione = $request->input('ubicazione');
//        $marca = $request->input('marca');
//        $modello = $request->input('modello');
//        $colore = $request->input('colore');
//        $nota = $request->input('nota');
//        $immagini = $request->file('immagini');

  

    //    if ($immagine) {
    //     // Ottieni il nome originale del file
    //     $nomefile = $immagine->getClientOriginalName();
    
    //     // Esempio: Salva il file in una directory specifica
    //     $path = $immagine->storeAs('uploads', $nomefile, 'public');
    
    // } else {
        
    //     $path = '';
    // }


//        $targa_veicolo = VeicoliManuali::where('targa', $targa)->select('targa', 'telaio', 'nuovo_usato')->first();
//        $telaio_veicolo = VeicoliManuali::where('telaio', $telaio)->select('targa', 'telaio', 'nuovo_usato')->first();

       


//    // Avvia una transazione per garantire l'integrità dei dati
//    DB::beginTransaction();

//    try {
//        // Controlla se esistono veicoli con la stessa targa o telaio, ignorando i record con valori NULL
//        $targa_veicolo = VeicoliManuali::whereNotNull('targa')->where('targa', $targa)->select('targa', 'telaio', 'nuovo_usato')->first();
//        $telaio_veicolo = VeicoliManuali::whereNotNull('telaio')->where('telaio', $telaio)->select('targa', 'telaio', 'nuovo_usato')->first();

//        // Se esiste un veicolo con la stessa targa ma con un telaio diverso
//        if ($targa_veicolo && !$telaio_veicolo) {
//            return back()->with('status', 'Errore: un veicolo con la targa: ' . $targa . ' esiste già')->with('targa', $targa);
//        }

//        // Se esiste un veicolo con lo stesso telaio ma con una targa diversa
//        elseif ($telaio_veicolo && !$targa_veicolo) {
//            return back()->with('status', 'Errore: un veicolo con il telaio: ' . $telaio . ' esiste già')->with('telaio', $telaio);
//        }

//        // Se esistono entrambi (targa e telaio) e sono associati allo stesso tipo di veicolo (nuovo/usato)
//        elseif ($targa_veicolo && $telaio_veicolo && $telaio_veicolo->nuovo_usato == $targa_veicolo->nuovo_usato) {
//            return back()->with('status', 'Errore: un veicolo con la targa ' . $targa . ' e il telaio ' . $telaio . ' esiste già')->with(['telaio' => $telaio, 'targa' => $targa]);
//        }

//        // Se esistono entrambi (targa e telaio), ma il tipo di veicolo (nuovo/usato) è diverso
//        elseif ($targa_veicolo && $telaio_veicolo && $telaio_veicolo->nuovo_usato != $targa_veicolo->nuovo_usato) {
//            return back()->with('status', 'Errore: due veicoli con la targa ' . $targa . ' e il telaio ' . $telaio . ' esistono già con tipo diverso (nuovo/usato)')->with(['telaio' => $telaio, 'targa' => $targa]);
//        } else {
//            // Creazione del nuovo veicolo
//            $veicolo_manuale = VeicoliManuali::create([
//                'nuovo_usato' => $nuovo_usato,
//                'status' => 'M',
//                'telaio' => $telaio,
//                'targa' => $targa,
//                'ubicazione' => $ubicazione,
//                'marca' => $marca,
//                'modello' => $modello,
//                'colore' => $colore,
//                'nota' => $nota,
//                'immagine' => '', // Inizialmente nessuna immagine
//            ]);

//            // Gestisci le immagini
//            if ($immagini) {
//                foreach ($immagini as $immagine) {
//                    // Ottieni il nome originale del file
//                    $nomefile = $immagine->getClientOriginalName();
//                    // Salva il file nella directory "uploads"
//                    $path = $immagine->storeAs('uploads', $nomefile, 'public');

//                    // Salva il percorso dell'immagine nella tabella "VeicoliImmagini"
//                    VeicoliImmagini::create([
//                        'id_veicolo' => $veicolo_manuale->id,
//                        'path_immagine' => $path,
//                    ]);
//                }
//            }

//            // Inserisci nel sistema dell'inventario
//            $nuovo_usato_trovata = $veicolo_manuale->nuovo_usato == 'n' ? 'mn' : 'mu';
//            Trovata::create([
//                'nuovo_usato' => $nuovo_usato_trovata,
//                'idveicolo' => $veicolo_manuale->id,
//                'trovata' => 1,
//                'id_operatore' => Auth::user()->id,
//                'user_operatore' => Auth::user()->name,
//                'dataOra' => now(),
//                'luogo' => $veicolo_manuale->ubicazione,
//            ]);
//        }

//        // Se tutte le operazioni sono andate a buon fine, committa la transazione
//        DB::commit();

//        return back()->with('status', 'Veicolo aggiunto correttamente');
//    } catch (\Exception $e) {
//        // In caso di errore, effettua il rollback della transazione
//        DB::rollBack();
//        return back()->with('status', 'Errore: ' . $e->getMessage());
//    }
          
//     }



public function store(Request $request)
{
    // ------------------------------------ VALIDAZIONE ------------------------------------ //
    $validated = $request->validate([
        'marca' => 'required',
        'modello' => 'required',
        'nota' => 'required',
    ]);

    // ------------------------------------ DATI DELLA RICHIESTA ------------------------------------ //

    $nuovo_usato = $request->input('nuovo_usato');
    $targa = $request->input('targa');
    $telaio = $request->input('telaio');
    $ubicazione = $request->input('ubicazione');
    $marca = $request->input('marca');
    $modello = $request->input('modello');
    $colore = $request->input('colore');
    $nota = $request->input('nota');
    $immaginiCaricate = $request->file('immagini'); // Immagini caricate come file
    $immaginiBase64 = $request->input('foto_base64'); // Immagini Base64

    

    // ------------------------------------ TRANSAZIONE ------------------------------------ //

    DB::beginTransaction();

    try {
        // Controlli su targa e telaio (come nel tuo codice esistente)
        $targa_veicolo = VeicoliManuali::whereNotNull('targa')->where('targa', $targa)->select('targa', 'telaio', 'nuovo_usato')->first();
        $telaio_veicolo = VeicoliManuali::whereNotNull('telaio')->where('telaio', $telaio)->select('targa', 'telaio', 'nuovo_usato')->first();

        if ($targa_veicolo && !$telaio_veicolo) {
            return back()->with('status', 'Errore: un veicolo con la targa: ' . $targa . ' esiste già')->with('targa', $targa);
        } elseif ($telaio_veicolo && !$targa_veicolo) {
            return back()->with('status', 'Errore: un veicolo con il telaio: ' . $telaio . ' esiste già')->with('telaio', $telaio);
        } elseif ($targa_veicolo && $telaio_veicolo && $telaio_veicolo->nuovo_usato == $targa_veicolo->nuovo_usato) {
            return back()->with('status', 'Errore: un veicolo con la targa ' . $targa . ' e il telaio ' . $telaio . ' esiste già')->with(['telaio' => $telaio, 'targa' => $targa]);
        }

        // Creazione del veicolo
        $veicolo_manuale = VeicoliManuali::create([
            'nuovo_usato' => $nuovo_usato,
            'status' => 'M',
            'telaio' => $telaio,
            'targa' => $targa,
            'ubicazione' => $ubicazione,
            'marca' => $marca,
            'modello' => $modello,
            'colore' => $colore,
            'nota' => $nota,
            'immagine' => '', // Inizialmente vuoto
        ]);

        // ------------------------------------ GESTIONE IMMAGINI ------------------------------------ //

        // Salva immagini caricate come file
        if ($immaginiCaricate) {
            foreach ($immaginiCaricate as $immagine) {
                if ($immagine) {
                $nomefile = $immagine->getClientOriginalName();
                $path = $immagine->storeAs('uploads', $nomefile, 'public');
                VeicoliImmagini::create([
                    'id_veicolo' => $veicolo_manuale->id,
                    'path_immagine' => $path,
                ]);

                }
            }
        }

        \Log::info($immaginiBase64);

        // Salva immagini caricate in Base64
        if ($immaginiBase64) {
            foreach ($immaginiBase64 as $base64) {
                \Log::info('Immagini Base64:', ['count' => count($immaginiBase64)]);
                if (!empty($base64)) {
                // Decodifica l'immagine Base64 e salva come file
                $nomefile = 'base64_' . uniqid() . '.png';
                $path = 'uploads/' . $nomefile;
                Storage::disk('public')->put($path, base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64)));

                // Salva il percorso nella tabella "VeicoliImmagini"
                VeicoliImmagini::create([
                    'id_veicolo' => $veicolo_manuale->id,
                    'path_immagine' => $path,
                ]);

              }
            }
        }

        // ------------------------------------ AGGIUNGI A INVENTARIO ------------------------------------ //
        $nuovo_usato_trovata = $veicolo_manuale->nuovo_usato == 'n' ? 'mn' : 'mu';
        Trovata::create([
            'nuovo_usato' => $nuovo_usato_trovata,
            'idveicolo' => $veicolo_manuale->id,
            'trovata' => 1,
            'id_operatore' => Auth::user()->id,
            'user_operatore' => Auth::user()->name,
            'dataOra' => now(),
            'luogo' => $veicolo_manuale->ubicazione,
        ]);

        // Commit della transazione
        DB::commit();

        return back()->with('status', 'Veicolo aggiunto correttamente');
    } catch (\Exception $e) {
        // Rollback della transazione in caso di errore
        DB::rollBack();
        return back()->with('status', 'Errore: ' . $e->getMessage());
    }
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
    public function destroy(Request $request)
    {
        
         // Cancella i file associati di VeicoliImmagini
    $immagini = VeicoliImmagini::all();
    foreach ($immagini as $immagine) {
        // Costruisci il percorso completo del file
        $filePath = "public/" . $immagine->path_immagine;

        // Verifica se il file esiste nello storage e lo elimina
        if (Storage::exists($filePath)) {
            Storage::delete($filePath);
        }
    }

    // Cancella i record dalle tabelle
    VeicoliManuali::truncate();
    VeicoliImmagini::truncate();

        return back()->with('status', 'Veicoli Manuali svuotati');

    }
}
