<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tiket extends Model
{
    protected $table = "tiket" ;
    protected $primaryKey = "id" ;
    protected $fillable = [
        'id_film_tayang', 'id_petugas', 'harga', 'tgl', 'jumlah', 'total',
    ];

    public $timestamps = false ;

}
