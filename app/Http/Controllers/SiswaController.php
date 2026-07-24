<?php

namespace App\Http\Controllers;

use App\Http\Requests\SiswaRequest;
use App\Models\Rombel;
use App\Models\RiwayatKelasSiswa;
use App\Models\Siswa;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function index(Request $req)
    {
        $siswas = Siswa::with(['rombelAktifRelation.kelas.jurusan'])
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
        $data = $req->validated();
        if ($req->hasFile('url_foto')) {
            $file = $req->file('url_foto');
            if (!@getimagesize($file->getPathname())) {
                return back()->withErrors(['url_foto' => 'File yang diupload bukan gambar valid.'])->withInput();
            }
            $data['url_foto'] = $file->store('foto-siswa', 'public');
        }
        $siswa = Siswa::create($data);

        if ($req->filled('rombel_id')) {
            $activeTa = TahunAjaran::where('aktif', true)->first();
            if ($activeTa) {
                RiwayatKelasSiswa::create([
                    'siswa_id' => $siswa->id,
                    'rombel_id' => $req->rombel_id,
                    'tahun_ajaran_id' => $activeTa->id,
                    'status' => 'aktif',
                    'tanggal_masuk' => now(),
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
        $data = $req->validated();
        if ($req->hasFile('url_foto')) {
            $file = $req->file('url_foto');
            if (!@getimagesize($file->getPathname())) {
                return back()->withErrors(['url_foto' => 'File yang diupload bukan gambar valid.'])->withInput();
            }
            if ($siswa->url_foto) {
                Storage::disk('public')->delete($siswa->url_foto);
            }
            $data['url_foto'] = $file->store('foto-siswa', 'public');
        }
        $siswa->update($data);

        $activeTa = TahunAjaran::where('aktif', true)->first();
        if ($activeTa) {
            if ($req->filled('rombel_id')) {
                RiwayatKelasSiswa::updateOrCreate(
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
                RiwayatKelasSiswa::where('siswa_id', $siswa->id)
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
