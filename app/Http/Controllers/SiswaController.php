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
        $siswas = Siswa::with(['riwayatKelas.rombel.kelas.jurusan'])
            ->search($req->search)
            ->filter(['agama' => $req->agama, 'kelamin' => $req->kelamin])
            ->paginate(10)
            ->withQueryString();

        return view('siswa.index', compact('siswas'));
    }

    public function create()
    {
        $rombels = Rombel::with(['kelas.jurusan'])->orderBy('tingkat')->get();
        return view('siswa.form', compact('rombels'));
    }

    public function store(SiswaRequest $req)
    {
        $siswa = Siswa::create($req->validated());

        if ($req->filled('rombel_id')) {
            $activeTa = \App\Models\TahunAjaran::where('aktif', true)->first();
            if ($activeTa) {
                \App\Models\RiwayatKelasSiswa::create([
                    'siswa_id' => $siswa->id,
                    'rombel_id' => $req->rombel_id,
                    'tahun_ajaran_id' => $activeTa->id,
                ]);
            }
        }

        return redirect()->route('siswa')->with('success', 'Siswa berhasil ditambahkan.');
    }

    public function edit(Siswa $siswa)
    {
        $rombels = Rombel::with(['kelas.jurusan'])->orderBy('tingkat')->get();
        return view('siswa.form', compact('siswa', 'rombels'));
    }

    public function update(SiswaRequest $req, Siswa $siswa)
    {
        $siswa->update($req->validated());

        $activeTa = \App\Models\TahunAjaran::where('aktif', true)->first();
        if ($activeTa) {
            if ($req->filled('rombel_id')) {
                \App\Models\RiwayatKelasSiswa::updateOrCreate(
                    [
                        'siswa_id' => $siswa->id,
                        'tahun_ajaran_id' => $activeTa->id,
                    ],
                    [
                        'rombel_id' => $req->rombel_id,
                        'status' => 'aktif',
                        'tanggal_masuk' => now(),
                    ]
                );
            } else {
                \App\Models\RiwayatKelasSiswa::where('siswa_id', $siswa->id)
                    ->where('tahun_ajaran_id', $activeTa->id)
                    ->delete();
            }
        }

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
