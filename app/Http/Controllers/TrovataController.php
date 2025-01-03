<?php

namespace App\Http\Controllers;

use App\Models\Trovata;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class TrovataController extends Controller
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

      $dateNow = Carbon::now()->format('Y-m-d H:i:s');
        
     $trovata = Trovata::create([
 
        'nuovo_usato'=> $request->input('nuovo_usato'),
        'idveicolo'=> $request->input('idveicolo'),
        'trovata'=> 1,
        'id_operatore'=>$request->input('id_operatore'),
        'user_operatore'=>$request->input('user_operatore'),
        'dataOra'=>$dateNow,
        'luogo'=>$request->input('ubicazione'),
        'latitudine'=>$request->input('latitudine'),
        'longitudine'=>$request->input('longitudine'),
        'gps_indirizzo'=>$request->input('indirizzo_gps'),
        
      ]);

        
        // return back()->with('status', 'il veicolo è stato inventariato');

        return response()->json(['trovata' => $trovata]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Trovata  $trovata
     * @return \Illuminate\Http\Response
     */
    public function show(Trovata $trovata)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Trovata  $trovata
     * @return \Illuminate\Http\Response
     */
    public function edit(Trovata $trovata)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Trovata  $trovata
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Trovata $trovata)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Trovata  $trovata
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Trovata $trovata)
    {

        $idveicolo = $request->input('trovata');

        $trovata = Trovata::whereIdveicolo($idveicolo)->first();

        $trovata->delete();

        


        return back()->with('status', 'veicolo rimosso dallo stato inventariato');
    }


    public function destroyAll(Request $request)
    {

            $request->validate([
            'secret_password' => 'required',
                              ]);

         // Ottieni la password segreta dal file di configurazione
         $secretPassword = config('svuota-db.secret_password');  

         if ($request->input('secret_password') !== $secretPassword) {
        return redirect()->back()->with(['error' => 'Password segreta errata.']);
    }

        $inventario = Trovata::all(); 

        if (Trovata::count() === 0) {
            return back()->with('status', 'Nessun veicolo in inventario da rimuovere.');
        }

        foreach ($inventario as $trovata) {
            $trovata->delete();
        }

        
        

        return back()->with('status', 'veicoli rimossi dallo stato inventariato');
    }
}
