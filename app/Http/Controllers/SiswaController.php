<?php

namespace App\Http\Controllers;

use App\Http\Requests\SiswaRequest;
use App\Models\Rombel;
use App\Models\Siswa;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function index(Request $req)
    {
        $siswas = Siswa::with('rombel.kelas')
            ->search($req->search)
            ->paginate(10)
            ->withQueryString();

        return view('siswa.index', compact('siswas'));
    }

    public function create()
    {
        $rombels = Rombel::with('kelas')->orderBy('tingkat')->get();
        return view('siswa.form', compact('rombels'));
    }

    public function store(SiswaRequest $req)
    {
        Siswa::create($req->validated());
        return redirect()->route('siswa')->with('success', 'Siswa berhasil ditambahkan.');
    }

    public function edit(Siswa $siswa)
    {
        $rombels = Rombel::with('kelas')->orderBy('tingkat')->get();
        return view('siswa.form', compact('siswa', 'rombels'));
    }

    public function update(SiswaRequest $req, Siswa $siswa)
    {
        $siswa->update($req->validated());
        return redirect()->route('siswa')->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function destroy(Siswa $siswa, Request $req)
    {
        $nama   = $siswa->nama;
        $alasan = $req->input('alasan_hapus', '-');

        $siswa->update([
            'status' => '2',
            'alasan_hapus' => $alasan
        ]);

        return redirect()->route('siswa')
            ->with('success', "Data siswa \"{$nama}\" berhasil dihapus. Alasan: {$alasan}");
    }
}
