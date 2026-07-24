<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Jurusan;
use App\Models\Rombel;
use App\Models\TahunAjaran;
use App\Http\Requests\KelasRombelRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

// Controller for creating grades & study groups together.
class KelasRombelController extends Controller
{
    // Show the combined grade + study group creation form.
    public function createKelasRombel()
    {
        $jurusans = Jurusan::orderBy('nama')->get();
        $tahunAjaran = TahunAjaran::where('aktif', true)->first();
        $kurikulums = \App\Models\Kurikulum::where('status', true)->get();

        return view('kelas.form-kelas-rombel', compact('jurusans', 'tahunAjaran', 'kurikulums'));
    }

    // Store a new grade and its associated study groups.
    public function storeKelasRombel(KelasRombelRequest $req): RedirectResponse
    {
        $kelas = Kelas::create($req->only('jurusan_id', 'tingkat'));

        if ($req->filled('rombels')) {
            foreach ($req->rombels as $rombel) {
                Rombel::create([
                    'kelas_id' => $kelas->id,
                    'tahun_ajaran_id' => $rombel['tahun_ajaran_id'],
                    'tingkat' => $rombel['tingkat'],
                    'kurikulum_id' => $rombel['kurikulum_id'] ?? 1,
                ]);
            }
        }

        return redirect()->route('kelas')->with('success', 'Kelas & rombel berhasil ditambahkan.');
    }

    // Delete a study group.
    public function destroyKelasRombel(Rombel $rombel): RedirectResponse
    {
        try {
            $rombel->delete();
            return redirect()->route('kelas')->with('success', 'Rombel berhasil dihapus.');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == 23000) {
                return redirect()->route('kelas')->with('error', 'Gagal menghapus rombel. Rombel masih memiliki riwayat siswa atau penugasan wali kelas yang terikat.');
            }
            throw $e;
        }
    }

    // Show form to assign students to a rombel
    public function assignSiswa(Rombel $rombel)
    {
        // Get only the IDs of students currently assigned to this rombel
        $assignedSiswaIds = \App\Models\RiwayatKelasSiswa::where('rombel_id', $rombel->id)
            ->pluck('siswa_id')
            ->toArray();
            
        // Eager load related kelas and jurusan for UI context
        $rombel->load(['kelas.jurusan']);

        return view('kelas.assign-siswa', compact('rombel', 'assignedSiswaIds'));
    }

    // API endpoint for fetching paginated students
    public function apiSiswas(Request $req)
    {
        $taId = $req->input('ta_id');
        
        // Ensure request has the correct active ta id for calculating active rombel
        if ($taId) {
            $req->attributes->set('active_ta_id', $taId);
        }

        $query = \App\Models\Siswa::with('rombelAktifRelation')
            ->orderBy('nama', 'asc');

        if ($req->filled('q')) {
            $query->search($req->q);
        }
        
        if ($req->boolean('filter_selected') && $req->has('selected_ids')) {
            $query->whereIn('id', $req->selected_ids);
        }

        $paginator = $query->paginate(20);

        // Map through items to inject active rombel data
        $paginator->getCollection()->transform(function ($siswa) {
            return [
                'id' => $siswa->id,
                'nama' => $siswa->nama,
                'nis' => $siswa->nis,
                'rombel_aktif' => $siswa->rombelAktif(),
            ];
        });

        return response()->json($paginator);
    }

    // Save student assignments to rombel
    public function updateAssignSiswa(Request $request, Rombel $rombel): RedirectResponse
    {
        $request->validate([
            'siswa_ids' => 'nullable|array',
            'siswa_ids.*' => 'exists:siswas,id'
        ]);

        $siswaIds = $request->siswa_ids ?? [];
        $activeTa = $rombel->tahun_ajaran_id;

        // Validasi: Pastikan siswa yang dipilih belum memiliki rombel lain yang aktif di tahun ajaran ini
        if (!empty($siswaIds)) {
            $alreadyAssigned = \App\Models\RiwayatKelasSiswa::whereIn('siswa_id', $siswaIds)
                ->where('tahun_ajaran_id', $activeTa)
                ->where('rombel_id', '!=', $rombel->id)
                ->with('siswa')
                ->get();

            if ($alreadyAssigned->count() > 0) {
                $names = $alreadyAssigned->map(function ($r) {
                    return $r->siswa ? $r->siswa->nama : 'Siswa tidak diketahui';
                })->unique()->implode(', ');
                
                return redirect()->back()->with('error', "Gagal menyimpan: Siswa berikut sudah terdaftar di kelas lain pada tahun ajaran ini: $names.");
            }
        }

        // 1. Remove unchecked students from this rombel (for the active year)
        \App\Models\RiwayatKelasSiswa::where('rombel_id', $rombel->id)
            ->whereNotIn('siswa_id', $siswaIds)
            ->delete();

        // 2. Insert or Update assigned students
        foreach ($siswaIds as $siswaId) {
            \App\Models\RiwayatKelasSiswa::updateOrCreate(
                [
                    'siswa_id' => $siswaId,
                    'tahun_ajaran_id' => $activeTa,
                ],
                [
                    'rombel_id' => $rombel->id,
                    'status' => 'aktif',
                    'tanggal_masuk' => now(),
                ]
            );
        }

        return redirect()->route('kelas')->with('success', 'Siswa berhasil diatur untuk rombel tersebut.');
    }

    // API endpoint for fetching students of a specific rombel (for modal detail)
    public function siswaByRombel(Rombel $rombel)
    {
        // Ambil siswa yang memiliki riwayat kelas aktif di rombel ini
        // Batasi hingga 100 untuk mencegah issue performa dan DOM overload
        $siswas = \App\Models\Siswa::whereHas('riwayatKelas', function ($q) use ($rombel) {
            $q->where('rombel_id', $rombel->id)
              ->where('status', 'aktif')
              ->where('tahun_ajaran_id', $rombel->tahun_ajaran_id);
        })
        ->select(['id', 'nama', 'nis'])
        ->orderBy('nama')
        ->take(100)
        ->get();

        return response()->json($siswas);
    }
}
