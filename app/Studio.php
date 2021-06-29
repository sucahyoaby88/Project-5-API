<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Studio extends Model
{
    protected $table = "studio" ;
    protected $primaryKey = "id" ;
    protected $fillable = [
        'nama_studio',
    ];

    public $timestamps = false ;
}
