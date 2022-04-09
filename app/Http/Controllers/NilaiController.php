<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use App\Models\Mahasiswa_Matakuliah;

class NilaiController extends Controller
{
    //
    public function index(Mahasiswa $mahasiswa){
        $nilai = Mahasiswa_Matakuliah::where('mahasiswa_id',$mahasiswa->id)->get();
        return view('mahasiswa.nilai',[
            'mahasiswa' => $mahasiswa,
            'nilai1'=>$nilai]);
    }
}
