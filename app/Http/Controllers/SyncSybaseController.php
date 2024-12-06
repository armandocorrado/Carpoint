<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
// use Illuminate\Database\Eloquent\Collection;
use App\Models\VeicoliUsati;
use App\Models\VeicoliNuovi;
use function importNuoviSybase;
use function importUsatiSybase;


class SyncSybaseController extends Controller
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


    public function sync_nuovi(){

        $data = array();
        $data = importNuoviSybase();

        $data =   mb_convert_encoding($data, "UTF-8");  
		
	

        VeicoliNuovi::truncate();

        foreach ($data as $item) {

            $test =  VeicoliNuovi::create($item);
      
      
          }
   

        return redirect('/');
    }


    
    public function sync_usati(Request $request){

        $data = array();
        $data = importUsatiSybase();

        $data =   mb_convert_encoding($data, "UTF-8"); 

        VeicoliUsati::truncate();


    foreach ($data as $item) {

      $test =  VeicoliUsati::create($item);


    }



       return redirect('/');
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
