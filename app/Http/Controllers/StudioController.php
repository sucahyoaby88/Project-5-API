<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Studio;
use Auth;
use Illuminate\Support\Facades\Validator;


class StudioController extends Controller
{
    public function show()
    {
        if(Auth::user()->level == 'admin'){
            $dt_studio=Studio::get();
            return Response()->json($dt_studio);
        }else{
            return Response()->json('Anda Bukan admin');
        }
    }

    public function store(Request $req){
        if(Auth::user()->level == 'admin'){
        
        $validator = Validator::make($req->all(),
        [
            'nama_studio'=>'required'
        ]
        );
        if($validator->fails()){
            return Response()->json($validator->errors());
        }

        $simpan = Studio::create([
            'nama_studio'=>$req->nama_studio
            
        ]);
        if($simpan){
            return Response()->json('Data Studio berhasil ditambahkan');
        }else{
            return Response()->json('Data Studio gagal ditambahkan');
        }
    }else{
        return Response()->json('Anda Bukan admin');
    }
    }

    public function update($id,Request $req){
        if(Auth::user()->level == 'admin'){

        $validator = Validator::make($req->all(),
        [
            'nama_studio'=>'required'
        ]
        );
        if($validator->fails()){
            return Response()->json($validator->errors());
        }

        $ubah = Studio::where('id', $id)->update([
            'nama_studio'=>$req->nama_studio
        ]);
        if($ubah){
            return Response()->json('Data Studio berhasil diubah');
        }else{
            return Response()->json('Data Studio gagal diubah');
        }
    }else{
        return Response()->json('Anda Bukan admin');
    }
    }

    public function destroy($id){
        if(Auth::user()->level == 'admin'){

        $hapus = Studio::where('id', $id)->delete();
        if($hapus){
            return Response()->json('Data Studio berhasil dihapus');
        }else{
            return Response()->json('Data Studio gagal dihapus');
        }
    }else{
        return Response()->json('Anda Bukan admin');
    }
    }
}
