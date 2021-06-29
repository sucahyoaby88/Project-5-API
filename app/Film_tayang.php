<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Film_tayang extends Model
{
    protected $table = "film_tayang" ;
    protected $primaryKey = "id" ;
    protected $fillable = [
        'id_film', 'id_studio', 'waktu',
    ];

    public $timestamps = false ;
}
