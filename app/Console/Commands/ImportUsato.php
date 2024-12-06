<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use function importUsatiSybase;
use App\Models\VeicoliUsati;

class ImportUsato extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:usato';

    /**
     * The console command description.
     *
     * @var string
     */

    protected $description = 'Importo da sybase gli ultimi 800 veicoli usati';

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
        $data = importUsatiSybase();

        $data =   mb_convert_encoding($data, "UTF-8");

        VeicoliUsati::truncate();


    foreach ($data as $item) {

       VeicoliUsati::create($item);


    }


    }
}
