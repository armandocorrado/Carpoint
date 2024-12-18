<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VeicoliManuali extends Model
{
    use HasFactory;

    protected $guarded = [];


    //relazioni

    public function immagini(){

        return $this->hasMany(VeicoliImmagini::class, 'id_veicolo');

    }
}
