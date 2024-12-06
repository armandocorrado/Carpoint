<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\VeicoliNuovi;
use function importNuoviSybase;

class ImportNuovo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:nuovo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importo da sybase gli ultimi 800 veicoli nuovi';

    /**
     * Execute the console command.
     *
     * @return int
     */

     public function __construct()
     {
         parent::__construct();
     }


    public function handle()
    {
        
        $data = array();
        $data = importNuoviSybase();

        $data =   mb_convert_encoding($data, "UTF-8"); 

        VeicoliNuovi::truncate();

        foreach ($data as $item) {

              VeicoliNuovi::create($item);
      
      
          }
   

    }
}
