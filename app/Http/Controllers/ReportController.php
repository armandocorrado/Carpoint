<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpWord\TemplateProcessor;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill; // Importazione aggiuntiva
use App\Models\VeicoliUsati;
use App\Models\VeicoliNuovi;
use App\Models\VeicoliManuali;
use App\Models\Trovata;

class ReportController extends Controller
{


   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        

        return view('report.report_doc');
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

   // ANCHOR report_usati()
    public function report_usati(){

   

        $id_veicolo = [];

        $v_usati = VeicoliUsati::all(); 

        foreach($v_usati as $id ){

            $idveicolo[] = $id->id_veicolo;
        }
        


        /* INIZIO INTERROGAZIONE DB PER "TROVATA" */
    
        $trovata = Trovata::whereNuovo_usato('u')->whereIn('idveicolo', $idveicolo)->get();  

        


        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $header = [
            'id_veicolo',
            'marca',
            'modello',
            'targa',
            'vin',
            'colore',
            'colint',
            'ubicazione',
            'desc_ubicazione',
            'status_veicolo',
            'vendibilita',
            'tipologia_destinazioni',
            'numero_contratto',
            'data_contratto',
            'data_fattura_v',
            'data_immatricolazione',
            'note',
            'inventario',
            'operatore_inventario',
            'data_ora_inventario',
            'ubicazione_inventario',
            'note_programma'
        ];

        $sheet->fromArray([$header], NULL, 'A1');

        $data = [];


foreach ($v_usati as $veicolo) {
    if($t = in_array($veicolo->id_veicolo, $trovata->pluck('idveicolo')->toArray())){
        
foreach($trovata as $t){
    if($t->idveicolo == $veicolo->id_veicolo){
    

     $inventario ="SI";
     $operatore_inventario = $t->user_operatore;
     $data_ora_inventario = $t->dataOra;
     $ubicazione_inventario = $t->luogo;


    }

}

   
    $row = [
        
        $veicolo->id_veicolo,
        $veicolo->marca,
        $veicolo->modello,
        $veicolo->targa,
        $veicolo->vin,
        $veicolo->colore,
        $veicolo->colint,
        $veicolo->ubicazione,
        $veicolo->desc_ubicazione,
        $veicolo->status_veicolo,
        $veicolo->vendibilita,
        $veicolo->tipologia,
        $veicolo->numero_contratto,
        $veicolo->data_contratto,
        $veicolo->data_fattura_v,
        $veicolo->data_immatricolazione,
        $veicolo->note,
        $inventario,
        $operatore_inventario,
        $data_ora_inventario,
        $ubicazione_inventario,
        $veicolo->note

    ];

    array_push($data, $row);

}else{


    $inventario ="NO";
    $operatore_inventario = "-";
    $data_ora_inventario = "-";
    $ubicazione_inventario = "-";


    $row = [
        
        $veicolo->id_veicolo,
        $veicolo->marca,
        $veicolo->modello,
        $veicolo->targa,
        $veicolo->vin,
        $veicolo->colore,
        $veicolo->colint,
        $veicolo->ubicazione,
        $veicolo->desc_ubicazione,
        $veicolo->status_veicolo,
        $veicolo->vendibilita,
        $veicolo->tipologia,
        $veicolo->numero_contratto,
        $veicolo->data_contratto,
        $veicolo->data_fattura_v,
        $veicolo->data_immatricolazione,
        $veicolo->note,
        $inventario,
        $operatore_inventario,
        $data_ora_inventario,
        $ubicazione_inventario,
        $veicolo->note

    ];

    array_push($data, $row);


 

}


}  

$sheet->fromArray($data, NULL, 'A2');


// Applica uno stile all'intestazione
$header_style = $sheet->getStyle('A1:W1');
$header_style->getFont()->setBold(true);
$header_style->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('C5D9F1');


$sheet->setTitle('Veicoli Usati');
$writer = new Xlsx($spreadsheet);
$filename = 'veicoli_usati.xlsx';
$writer->save($filename);


return response()->download($filename)->deleteFileAfterSend();


    

  

// $writer = new Xlsx($spreadsheet); 

        
// $writer->save('report_usato/v_usati.xlsx'); 

        


       


        return back();
    }


    
    //ANCHOR report_nuovi()
    public function report_nuovi(){

        $v_nuovi = VeicoliNuovi::all();

        foreach($v_nuovi as $id ){

            $idveicolo[] = $id->id_veicolo;
        }


        /* INIZIO INTERROGAZIONE DB PER "TROVATA" */
        $trovata = Trovata::whereNuovo_usato('n')->whereIn('idveicolo', $idveicolo)->get(); 


        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $header = [
                        "id_veicolo",
                        "descrizione_marca",
                        "descrizione_modello",
                        "targa",
                        "telaio",
                        "status",
                        "colore",
                        "interni",
                        "ubicazione",
                        "descrizione_ubicazioni",
                        "tipo_contratto",
                        "numero_contratto",
                        "data_contratto",
                        "data_uscita",
                        "linea",
                        "data_fattura_v",
                        "data_immatricolazione",
                        "note",
                        "inventario",
                        "operatore_inventario",
                        "data_ora_inventario",
                        "ubicazione_inventario",
                       
        ];

        $sheet->fromArray([$header], NULL, 'A1');

        $data = [];


foreach ($v_nuovi as $veicolo) {

    if($t = in_array($veicolo->id_veicolo, $trovata->pluck('idveicolo')->toArray())){

        foreach($trovata as $t){
            if($t->idveicolo == $veicolo->id_veicolo){

                $inventario ="SI";
                $operatore_inventario = $t->user_operatore;
                $data_ora_inventario = $t->dataOra;
                $ubicazione_inventario = $t->luogo;

    }

}
            


    $row = [
        
        $veicolo->id_veicolo,  
        $veicolo->descrizione_marca,
        $veicolo->descrizione_modello,
        $veicolo->targa,
        $veicolo->telaio,
        $veicolo->status,
        $veicolo->colore,
        $veicolo->interni,
        $veicolo->ubicazione,
        $veicolo->descrizione_ubicazioni,
        $veicolo->tipo_contratto,
        $veicolo->numero_contratto,
        $veicolo->data_contratto,
        $veicolo->data_uscita,
        $veicolo->linea,
        $veicolo->data_fattura_v,
        $veicolo->data_immatricolazione,  
        $veicolo->note,
        $inventario,
        $operatore_inventario,
        $data_ora_inventario,
        $ubicazione_inventario,
        
    ];

    array_push($data, $row);

}else{

    $inventario ="NO";
    $operatore_inventario = "-";
    $data_ora_inventario = "-";
    $ubicazione_inventario = "-";


    $row = [
        
        $veicolo->id_veicolo,  
        $veicolo->descrizione_marca,
        $veicolo->descrizione_modello,
        $veicolo->targa,
        $veicolo->telaio,
        $veicolo->status,
        $veicolo->colore,
        $veicolo->interni,
        $veicolo->ubicazione,
        $veicolo->descrizione_ubicazioni,
        $veicolo->tipo_contratto,
        $veicolo->numero_contratto,
        $veicolo->data_contratto,
        $veicolo->data_uscita,
        $veicolo->linea,
        $veicolo->data_fattura_v,
        $veicolo->data_immatricolazione,  
        $veicolo->note,
        $inventario,
        $operatore_inventario,
        $data_ora_inventario,
        $ubicazione_inventario,
        
    ];

    array_push($data, $row);


      }

}

$sheet->fromArray($data, NULL, 'A2');


// Applica uno stile all'intestazione
$header_style = $sheet->getStyle('A1:W1');
$header_style->getFont()->setBold(true);
$header_style->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('C5D9F1');


$sheet->setTitle('Veicoli Nuovi');
$writer = new Xlsx($spreadsheet);
$filename = 'veicoli_nuovi.xlsx';
$writer->save($filename);


return response()->download($filename)->deleteFileAfterSend();


    }


    //ANCHOR report_manuali_usato()
    public function report_manuali_usato(){

        $v_manuali = VeicoliManuali::whereNuovo_usato('u')->get();


        $id_veicolo = [];


        /* INIZIO INTERROGAZIONE DB PER "TROVATA" */
        // $trovata = Trovata::whereNuovo_usato('n')->whereIn('idveicolo', $v_nuovi[0]['id_veicolo'])->get(); 

    


        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $header = [

            "id",
            "status",
            "telaio",
            "targa",
            "ubicazione",
            "marca",
            "modello",
            "colore",
            "inventario",
            "operatore_inventario",
            "data_ora_inventario",
            "ubicazione_inventario",
            "note"
                       
        ];

        $sheet->fromArray([$header], NULL, 'A1');

        $data = [];


foreach ($v_manuali as $veicolo) {


    $row = [
        
        $veicolo->id,  
        $veicolo->status,
        $veicolo->telaio,
        $veicolo->targa,
        $veicolo->ubicazione,
        $veicolo->marca,
        $veicolo->modello,
        $veicolo->colore,
        $veicolo->inventario,
        $veicolo->operatore_inventario,
        $veicolo->data_ora_inventario,
        $veicolo->ubicazione_inventario,
        $veicolo->note
        
    ];

    array_push($data, $row);

}

$sheet->fromArray($data, NULL, 'A2');


// Applica uno stile all'intestazione
$header_style = $sheet->getStyle('A1:v1');
$header_style->getFont()->setBold(true);
$header_style->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('C5D9F1');


$sheet->setTitle('Veicoli Manuali usati');
$writer = new Xlsx($spreadsheet);
$filename = 'veicoli_nuovi.xlsx';
$writer->save($filename);


return response()->download($filename)->deleteFileAfterSend();


    }

    public function report_manuali_nuovo(){

        $v_manuali = VeicoliManuali::whereNuovo_usato('n')->get();


        /* INIZIO INTERROGAZIONE DB PER "TROVATA" */
        // $trovata = Trovata::whereNuovo_usato('n')->whereIn('idveicolo', $v_nuovi[0]['id_veicolo'])->get(); dd($trovata);


        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $header = [

            "id",
            "status",
            "telaio",
            "targa",
            "ubicazione",
            "marca",
            "modello",
            "colore",
            "inventario",
            "operatore_inventario",
            "data_ora_inventario",
            "ubicazione_inventario",
            "note"
                       
        ];

        $sheet->fromArray([$header], NULL, 'A1');

        $data = [];


foreach ($v_manuali as $veicolo) {


    $row = [
        
        $veicolo->id,  
        $veicolo->status,
        $veicolo->telaio,
        $veicolo->targa,
        $veicolo->ubicazione,
        $veicolo->marca,
        $veicolo->modello,
        $veicolo->colore,
        $veicolo->inventario,
        $veicolo->operatore_inventario,
        $veicolo->data_ora_inventario,
        $veicolo->ubicazione_inventario,
        $veicolo->note
        
    ];

    array_push($data, $row);

}

$sheet->fromArray($data, NULL, 'A2');


// Applica uno stile all'intestazione
$header_style = $sheet->getStyle('A1:v1');
$header_style->getFont()->setBold(true);
$header_style->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('C5D9F1');


$sheet->setTitle('Veicoli Manuali usati');
$writer = new Xlsx($spreadsheet);
$filename = 'veicoli_nuovi.xlsx';
$writer->save($filename);


return response()->download($filename)->deleteFileAfterSend();


    }
     

    //ANCHOR genera_tutti()
    public function genera_tutti(){


       $nuovo = $this->report_nuovi();
       $usato =  $this->report_usati();


            return response()->download($nuovo)
            ->download($usato);


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
