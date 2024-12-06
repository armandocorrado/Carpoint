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
use function importNuoviSybase;
use function importUsatiSybase;


class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    

    public function index()
    {
           $data = array();
           $data[] = importUsatiSybase();


         
        


          return view('welcome', compact('data'));
    }



   


    public function home()
    {
    return view("homeMain");
    }


    public function search()
    {
    return view("ricerca_veicoli");
    }


    public function report()
    {
    return view("report_doc");
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



    


    public function newVeicolo(){

      $input = $request->all();


      VeicoliManuali::create([

        $input


      ]);





        return back();
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
        //
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