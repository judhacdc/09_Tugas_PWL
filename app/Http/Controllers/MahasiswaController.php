<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use App\Models\Kelas;
class MahasiswaController extends Controller
{

    public function index()
    {
        //fungsi eloquent menampilkan data menggunakan pagination
        $mahasiswas = Mahasiswa::with('kelas')->get(); // Mengambil semua isi tabel
        $paginate = Mahasiswa::orderBy('id', 'asc')->paginate(3);
        return view('mahasiswa.index', ['mahasiswa' => $mahasiswas,'paginate'=>$paginate]);
    }
    // public function index()
    // {
    //    //fungsi eloquent menampilkan data menggunakan pagination
    //    $mahasiswas = Mahasiswa::paginate(5); // Mengambil semua isi tabel
    //    $posts = Mahasiswa::orderBy('Nim', 'desc')->paginate(5);
    //    return view('mahasiswa.index', compact('mahasiswas'));
    //    with('i', (request()->input('page', 1) - 1) * 5);

    // }

    public function create()
    {
        $kelas = Kelas::all();
        return view('mahasiswa.create',['kelas'=>$kelas]);
    }


    public function store(Request $request)
    {
        //melakukan validasi data
        $request->validate([ 'Nim' => 'required', 'Nama' => 'required','Email' => 'required',
        'TTL' => 'required', 'kelas_id' => 'required','Jurusan' => 'required', 'No_Handphone' => 'required',
        ]);
        Mahasiswa::create($request->all());
        return redirect()->route('mahasiswa.index')->with('success', 'Data berhasil ditambahkan');
    }

    // public function show($Nim)
    // {
    //     //menampilkan detail data dengan menemukan/berdasarkan Nim Mahasiswa
    //     $Mahasiswa = Mahasiswa::find($Nim);
    //     return view('mahasiswa.detail', compact('Mahasiswa'));

    // }

    public function show($Nim)
    {
        //menampilkan detail data dengan menemukan/berdasarkan Nim Mahasiswa
        $mahasiswas = Mahasiswa::with('kelas')->where('Nim',$Nim)->first();
        return view('mahasiswa.detail', ['Mahasiswa'=>$mahasiswas]);

    }



    public function edit($Nim)
    {
        //menampilkan detail data dengan menemukan berdasarkan Nim Mahasiswa untuk diedit
        $Mahasiswa = Mahasiswa::with('kelas')->where('Nim',$Nim)->first();
        $kelas = kelas::all();
        return view('mahasiswa.edit',compact('Mahasiswa','kelas'));

    }


    public function update(Request $request, Mahasiswa $mahasiswa)
    {
        //melakukan validasi data
        $validateData = $request->validate([
            'Nim' => 'required',
            'Nama' => 'required',
            'kelas_id' => 'required',
            'Jurusan' => 'required',
            'Email' => 'required',
            'No_Handphone' => 'required',
            'TTL' => 'required',
        ]);
        Mahasiswa::where('id', $mahasiswa->id)->update($validateData);
        return redirect()->route('mahasiswa.index')->with('success', 'Data berhasil diubah');

    }
    public function destroy($Nim)
    {
        //fungsi eloquent untuk menghapus data
        Mahasiswa::find($Nim)->delete();
        return redirect()->route('mahasiswa.index')
        -> with('success', 'Mahasiswa Berhasil Dihapus');
        return redirect()->route('mahasiswa.index')->with('success', 'Mahasiswa Berhasil Dihapus');
    }


    public function search(Request $request){
        $keyword = $request -> search;
        $mahasiswas = Mahasiswa::where('nama','like',"%". $keyword . "%") -> paginate(5);
        return view(view: 'mahasiswa.index', data: compact( var_name:'mahasiswas'));


    }
}
