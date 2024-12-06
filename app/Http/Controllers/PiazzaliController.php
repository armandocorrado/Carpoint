<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\VeicoliNuovi;
use App\Models\VeicoliUsati;
use App\Models\Trovata;
use App\Models\VeicoliManuali;

class PiazzaliController extends Controller
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
    



    public function piazzali()
    {

        $piazzali = DB::table(function ($query) {
            $query->select('descrizione_ubicazioni as piazzale')
                  ->from('veicoli_nuovis')
                  ->groupBy('piazzale')
                  ->unionAll(
                      DB::table('veicoli_usatis')
                        ->select('desc_ubicazione as piazzale')
                        ->groupBy('piazzale')
                  );
        }, 'piazzali')
        ->distinct()
        ->pluck('piazzale');


    return view("ricerca_piazzali", compact('piazzali'));
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
        
        $piazzali = $request->input('ubicazioni');
        $statusN = $request->input('status_n'); 
        $statusU = $request->input('status_u');
        
        $nuovi = "";
        $usati = "";
        $manuali_n ="";
        $manuali_u ="";

     
        if($piazzali != ""  &&  $statusN != "" ){
         $nuovi = VeicoliNuovi::whereIn('descrizione_ubicazioni',  $piazzali)->whereIn('status', $statusN )->get();  
     


        }  
      
        //conteggio il numero dei nuovi della query sopra
        $nNuovi = $nuovi->count(); 



        if($piazzali != ""  &&  $statusU != "" ){
         $usati = VeicoliUsati::whereIn('desc_ubicazione',  $piazzali)->whereIn('status_veicolo', $statusU )->get(); 
        }
        
        //conteggio il numero degli usati della query sopra
        $nUsati = $usati->count();



         $manuali_n = VeicoliManuali::whereStatus('M')->whereNuovo_usato('n')->whereIn('ubicazione', $piazzali)->get();
          //conteggio il numero dei veicoli manuali nuovi della query sopra
          $nNuoviManuali = $manuali_n->count();


         $manuali_u = VeicoliManuali::whereStatus('M')->whereNuovo_usato('u')->whereIn('ubicazione', $piazzali)->get();
         //conteggio il numero dei veicoli manuali usati della query sopra
         $nUsatiManuali = $manuali_u->count();

   

///////////////////////////////////////////////////// ciclo tutti gli id veicolo degli autoveicoli nuovi

  $idveicoloN = array();
 

  foreach($nuovi as $nuovi){


    $idveicoloN[]= $nuovi->id_veicolo;
 

  }  

//////////////////////////////////////////////////////


///////////////////////////////////////////////////// ciclo tutti gli id veicolo dei veicoli usati

$idveicoloU = array();

foreach($usati as $usati){


  $idveicoloU[]= $usati->id_veicolo;

}
//////////////////////////////////////////////////////


///////////////////////////////////////////////////// ciclo tutti gli id veicolo dei veicoli manuali nuovi
$idveicoloMN = array();

foreach($manuali_n as $manuali){


  $idveicoloMN[]= $manuali->id;

}
//////////////////////////////////////////////////////


///////////////////////////////////////////////////// ciclo tutti gli id veicolo dei veicoli manuali usati
$idveicoloMU = array();

foreach($manuali_u as $manuali){


  $idveicoloMU[]= $manuali->id;

}
/////////////////////////////////////////////////////////



// inizializzo le variabili
 /////////////////////////////////////// 

//  $nNuovi = 0;
 $nNuoviTrovati = 0;

//  $nUsati = 0;
 $nUsatiTrovati = 0;

//  $nNuoviManuali = 0;
 $nNuoviManualiTrovati = 0;

//  $nUsatiManuali = 0;
 $nUsatiManualiTrovati = 0;

 $veicoliNuoviDaInv = array();
 $veicoliUsatiDaInv = array();


 //---------------------------------------------------------------------------------------------------------------------


   // Trovo i veicoli nuovi inventariati...
    $queryNTrovata =  Trovata::whereNuovo_usato('n')->whereIn('idveicolo', $idveicoloN)->whereTrovata('1')->get(); 
    $queryUTrovata =  Trovata::whereNuovo_usato('u')->whereIn('idveicolo', $idveicoloU)->whereTrovata('1')->get();
    $queryMNTrovata =  Trovata::whereNuovo_usato('mn')->whereIn('idveicolo', $idveicoloMN)->whereTrovata('1')->get();
    $queryMUTrovata =  Trovata::whereNuovo_usato('mu')->whereIn('idveicolo', $idveicoloMU)->whereTrovata('1')->get();

//-------------------------------------------------------------------------------------------------------------------------------

   //catturo gli id dalla tabella trovata per sottrarli ai veicoli nuovi e cosi ottenere le auto nuove non inventariate

   $Id_nuovi_trovati = array();

   if($queryNTrovata){

       foreach($queryNTrovata as $idTrovata){

        $Id_nuovi_trovati[] = $idTrovata->idveicolo;

   } 
   



   $veicoliNuoviDaInv =  VeicoliNuovi::whereNotIn('id_veicolo' , $Id_nuovi_trovati )->whereIn('descrizione_ubicazioni',  $piazzali)->whereIn('status', $statusN )->get();  


   }  

   //-------------------------------------------------------------------------------------------------------------------------------


   //catturo gli id dalla tabella trovata per sottrarli ai veicoli usati e cosi ottenere le auto usate non inventariate

   $Id_usati_trovati = array();

   if($queryUTrovata){

       foreach($queryUTrovata as $idTrovata){

        $Id_usati_trovati[] = $idTrovata->idveicolo;

   } 
   



   $veicoliUsatiDaInv =  VeicoliUsati::whereNotIn('id_veicolo' , $Id_usati_trovati )->whereIn('desc_ubicazione',  $piazzali)->whereIn('status_veicolo', $statusU )->get();  


   }  

   //-------------------------------------------------------------------------------------------------------------------------------



   



//--------------------------------------------------------------------------------------------------------------------------------

// CONTEGGIO VEICOLI NUOVI E NUOVI INVENTARIATI - VEICOLI USATI E VEICOLI USATI INVENTARIATI E POI MANUALI USATI E NUOVI ED INVENTARIATI

    // $nNuovi = $nuovi->count(); 
    $nNuoviTrovati = $queryNTrovata->count() ?? ''; 

    // $nUsati = $usati->count();
    $nUsatiTrovati = $queryUTrovata->count() ?? '';

    // $nNuoviManuali = $manuali_n->count() ?? '';
    $nNuoviManualiTrovati = $queryMNTrovata->count() ?? '';

    // $nUsatiManuali = $manuali_u->count() ?? '';
    $nUsatiManualiTrovati = $queryMUTrovata->count() ?? '';



    //----------------------------------------------------------------------------------------------------------------

    //  SOMME E SOTTRAZIONI PER EVIDENZIARE LA DIFFERENZA TRA I VEICOLI INVENTARIATI E QUELLI 
        
  $nNuoviTot = $nNuovi + $nNuoviManuali; 
	$nUsatiTot = $nUsati + $nUsatiManuali;

	$nNuoviTrovatiTot = $nNuoviTrovati + $nNuoviManualiTrovati;
	$nUsatiTrovatiTot = $nUsatiTrovati + $nUsatiManualiTrovati;

	$nNuoviDaInTot = $nNuoviTot - $nNuoviTrovatiTot;
	$nUsatiDaInTot = $nUsatiTot - $nUsatiTrovatiTot;

         
    $test = ['invent'=> 'carrapipi']; 



    return response()->json([
                            
                           'nuovi' => $nuovi,
                           'nNuoviTot' => $nNuoviTot,
                           'nNuoviTrovatiTot'=> $nNuoviTrovatiTot,
                           'nNuoviDaInTot' => $nNuoviDaInTot, 
                           'nUsatiTot' => $nUsatiTot, 
                           'nUsatiTrovatiTot'=> $nUsatiTrovatiTot, 
                           'nUsatiDaInTot' => $nUsatiDaInTot,
                           'test'=>$test,
                           'veicoliNuoviDaInv' => $veicoliNuoviDaInv,
                           'veicoliUsatiDaInv' => $veicoliUsatiDaInv,
                           'statusN'=>$statusN
                        
                          ]);

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
