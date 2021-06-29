<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Hash;
use DB; 
use Auth;
use App\Tiket;

class TiketController extends Controller
{
    public function store(request $req){
        if(Auth::user()->level == 'petugas'){
        $id = Auth::User()->id;
            $tanggal = date('Y-m-d H:i:s');
            $validator = Validator::make($req->all(),[
            'id_film_tayang' => 'required',
            'harga' => 'required',
            'jumlah' => 'required',
            ]);
            if($validator->fails()){
                return response()->json($validator->errors());
            }
            $harga = $req->harga;
            $total = $harga * $req->jumlah;
            $tiket = Tiket::create([
            'tgl' => $tanggal,
            'id_film_tayang' => $req->id_film_tayang,
            'id_petugas' => $id,
            'harga' => $req->harga,
            'jumlah' => $req->jumlah,
            'total' => $total
            ]);
            if($tiket){
                $status = "Tiket berhasil ditambahkan";
                return response()->json(compact('status'));
            }
            else{
                $status = "Tiket gagal ditambahkan";
                return response()->json(compact('status'));
            }
        }else{
            $status = "Anda Bukan Petugas";
            return response()->json(compact('status'));
        }
    }
    public function show($id){
        if(Auth::user()->level == 'petugas'){
        $tiket = DB::table('tiket')->join('film_tayang','tiket.id_film_tayang','=','film_tayang.id')
                ->join('film','film_tayang.id_film','=','film.id')
                ->join('studio','film_tayang.id_studio','=','studio.id')
                ->join('petugas','tiket.id_petugas','=','petugas.id')
                ->where('tiket.id','=',$id)
                ->select('tiket.*','film_tayang.*','film.*','studio.*','petugas.*')
                ->first();
        $detail_tiket[] = array(
            'Id tiket' => $id,
            'Nama film' => $tiket->nama_film,
            'Jumlah tiket' => $tiket->jumlah,
            'Total' => $tiket->total
        );
        return response()->json(compact('detail_tiket'));
    }else{
        $status = "Anda Bukan Petugas";
        return response()->json(compact('status'));
    }
}
    public function update($id,Request $req){
        if(Auth::user()->level == 'petugas'){

        $validator = Validator::make($req->all(),
        [
            'id_film_tayang' => 'required',
            'harga' => 'required',
            'jumlah' => 'required',
        ]
        );
        if($validator->fails()){
            return Response()->json($validator->errors());
        }

        $harga = $req->harga;
            $total = $harga * $req->jumlah;
            $ubah = Tiket::where('id', $id)->update([
            'tgl' => $tanggal,
            'id_film_tayang' => $req->id_film_tayang,
            'id_petugas' => $id,
            'harga' => $req->harga,
            'jumlah' => $req->jumlah,
            'total' => $total
            ]);

        if($ubah){
            return Response()->json('Data tiket berhasil diubah');
        }else{
            return Response()->json('Data tiket gagal diubah');
        }
    }else{
        return Response()->json('Anda Bukan Petugas');
    }
    }

    public function destroy($id){
        if(Auth::user()->level == 'petugas'){

        $hapus = Tiket::where('id', $id)->delete();
        if($hapus){
            return Response()->json('Data Tiket berhasil dihapus');
        }else{
            return Response()->json('Data Tiket gagal dihapus');
        }
    }else{
        return Response()->json('Anda Bukan Petugas');
    }
}
}