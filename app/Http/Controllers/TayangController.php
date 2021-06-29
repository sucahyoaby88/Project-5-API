<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Hash;
use DB; 
use Auth;
use App\Film_tayang;

class TayangController extends Controller
{
    public function store(request $req){
        if(Auth::user()->level == 'admin'){
            $validator = Validator::make($req->all(),[
                'id_film' => 'required',
                'id_studio' => 'required',
                'waktu' => 'required|date'
            ]);
            if($validator->fails()){
                return response()->json($validator->errors());
            }
            $studio = Film_tayang::create([
                'id_studio' => $req->id_studio,
                'id_film' => $req->id_film,
                'waktu' => $req->waktu
            ]);
            if($studio){
                $status = "Data tayang film berhasil ditambahkan";
                return response()->json(compact('status'));
            }
            else{
                $status = "Data tayang film gagal ditambahkan";
                return response()->json(compact('status'));
            }
        }
        else{
            $status = "Anda Bukan Admin";
            return response()->json(compact('status'));
        }
    }
    public function show(request $req){
        $tayang = DB::table('film_tayang')->join('film','film_tayang.id_film','=','film.id')
                ->join('studio','film_tayang.id_studio','=','studio.id')
                ->where('film_tayang.waktu','like','%'.$req->waktu.'%')
                ->select('film_tayang.*','studio.*','film.*')
                ->get();
        $film = DB::table('film_tayang')->join('film','film_tayang.id_film','=','film.id')
                ->join('studio','film_tayang.id_studio','=','studio.id')
                ->where('film_tayang.waktu','like','%'.$req->waktu.'%')
                ->select('studio.*','film.*')
                ->get();
        
        if($film){
        $arr_film = array();
        foreach($film as $f){
            $arr_film[] = array(
            'Judul film' => $f->nama_film,
            'Genre' => $f->genre,
            'Tempat tayang' => $f->nama_studio
            );
        }
        }
        else{
            $arr_film = array();
            $arr_film[] = array(
                'tidak ada film yang tayang pada '.$req->waktu.''
            );
        }
        $jadwal[] = array(
            'Tanggal tayang' => $req->waktu,
            'Daftar film' => $arr_film,
        );
        return response()->json(compact('jadwal'));
    }
    
    public function update($id,Request $req){
        if(Auth::user()->level == 'admin'){

        $validator = Validator::make($req->all(),
        [
            'id_film' => 'required',
            'id_studio' => 'required',
            'waktu' => 'required|date'
        ]
        );
        if($validator->fails()){
            return Response()->json($validator->errors());
        }

        $ubah = Film_tayang::where('id', $id)->update([
            'id_studio' => $req->id_studio,
                'id_film' => $req->id_film,
                'waktu' => $req->waktu
        ]);
        if($ubah){
            return Response()->json('Data Film_tayang berhasil diubah');
        }else{
            return Response()->json('Data Film_tayang gagal diubah');
        }
    }else{
        return Response()->json('Anda Bukan admin');
    }
    }

    public function destroy($id){
        if(Auth::user()->level == 'admin'){

        $hapus = Film_tayang::where('id', $id)->delete();
        if($hapus){
            return Response()->json('Data Film_tayang berhasil dihapus');
        }else{
            return Response()->json('Data Film_tayang gagal dihapus');
        }
    }else{
        return Response()->json('Anda Bukan admin');
    }
    }
}
