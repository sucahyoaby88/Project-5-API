<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Film;
use Auth;
use Illuminate\Support\Facades\Validator;


class FilmController extends Controller
{
    public function show()
    {
        if(Auth::user()->level == 'admin'){
            $dt_film=Film::get();
            return Response()->json($dt_film);
        }else{
            return Response()->json('Anda Bukan admin');
        }
    }

    public function store(Request $req){
        if(Auth::user()->level == 'admin'){
        
        $validator = Validator::make($req->all(),
        [
            'nama_film'=>'required',
            'deskripsi'=>'required',
            'genre'=>'required'
        ]
        );
        if($validator->fails()){
            return Response()->json($validator->errors());
        }

        $simpan = Film::create([
            'nama_film'=>$req->nama_film,
            'deskripsi'=>$req->deskripsi,
            'genre'=>$req->genre
            
        ]);
        if($simpan){
            return Response()->json('Data Film berhasil ditambahkan');
        }else{
            return Response()->json('Data Film gagal ditambahkan');
        }
    }else{
        return Response()->json('Anda Bukan admin');
    }
    }

    public function update($id,Request $req){
        if(Auth::user()->level == 'admin'){

        $validator = Validator::make($req->all(),
        [
            'nama_film'=>'required',
            'deskripsi'=>'required',
            'genre'=>'required'
        ]
        );
        if($validator->fails()){
            return Response()->json($validator->errors());
        }

        $ubah = Film::where('id', $id)->update([
            'nama_film'=>$req->nama_film,
            'deskripsi'=>$req->deskripsi,
            'genre'=>$req->genre
        ]);
        if($ubah){
            return Response()->json('Data Film berhasil diubah');
        }else{
            return Response()->json('Data Film gagal diubah');
        }
    }else{
        return Response()->json('Anda Bukan admin');
    }
    }

    public function destroy($id){
        if(Auth::user()->level == 'admin'){

        $hapus = Film::where('id', $id)->delete();
        if($hapus){
            return Response()->json('Data Film berhasil dihapus');
        }else{
            return Response()->json('Data Film gagal dihapus');
        }
    }else{
        return Response()->json('Anda Bukan admin');
    }
    }
}
