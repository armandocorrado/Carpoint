<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VeicoliImmagini extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function veicolo()
    {
        return $this->belongsTo(VeicoliManuali::class, 'id_veicolo');
    }
}
