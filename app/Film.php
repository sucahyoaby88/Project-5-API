<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    protected $table = "film" ;
    protected $primaryKey = "id" ;
    protected $fillable = [
        'nama_film', 'deskripsi', 'genre',
    ];

    public $timestamps = false ;

}
