<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guru;
use App\Models\Mapel;
use App\Models\Rombel;
use App\Models\WaliKelas;
use App\Models\GuruMapel;

class PenugasanController extends Controller
{
    // --- WALI KELAS ---
    public function indexWaliKelas()
    {
        $waliKelas = WaliKelas::has('rombel')->with(['guru', 'rombel.kelas'])->get();
        
        // Data guru dikosongkan untuk mencegah DOM overload, di-load via AJAX `apiGurus`
        $gurus = collect();
        
        $rombels = Rombel::with(['kelas', 'kelas.jurusan'])->get();
        
        return view('penugasan.wali-kelas', compact('waliKelas', 'gurus', 'rombels'));
    }

    public function storeWaliKelas(Request $request)
    {
        $request->validate([
            'guru_id' => 'required|exists:gurus,id',
            'rombel_id' => 'required|exists:rombels,id|unique:wali_kelas,rombel_id',
        ], [
            'rombel_id.unique' => 'Rombel ini sudah memiliki Wali Kelas.',
        ]);

        WaliKelas::create($request->only('guru_id', 'rombel_id'));

        return redirect()->route('penugasan.wali-kelas')->with('success', 'Wali Kelas berhasil ditugaskan.');
    }

    public function destroyWaliKelas(WaliKelas $waliKelas)
    {
        $waliKelas->delete();
        return redirect()->route('penugasan.wali-kelas')->with('success', 'Tugas Wali Kelas berhasil dicabut.');
    }

    // --- GURU MAPEL ---
    public function indexGuruMapel()
    {
        $guruMapels = GuruMapel::has('rombel')->with(['guru', 'mapel', 'rombel.kelas'])->get();
        // Data guru dan mapel dikosongkan, di-load via AJAX `apiGurus` dan `apiMapels`
        $gurus = collect();
        $mapels = collect();
        $rombels = Rombel::with(['kelas', 'kelas.jurusan'])->get();

        return view('penugasan.guru-mapel', compact('guruMapels', 'gurus', 'mapels', 'rombels'));
    }

    public function storeGuruMapel(Request $request)
    {
        $request->validate([
            'guru_id' => 'required|exists:gurus,id',
            'mapel_id' => 'required|exists:mapels,id',
            'rombel_id' => 'required|array|min:1',
            'rombel_id.*' => 'exists:rombels,id',
        ]);

        $mapel = Mapel::find($request->mapel_id);
        if ($mapel && strtolower($mapel->kelompok) === 'kejuruan' && $mapel->jurusan_id) {
            foreach ($request->rombel_id as $rId) {
                $rombel = Rombel::with('kelas')->find($rId);
                if ($rombel && $rombel->kelas->jurusan_id != $mapel->jurusan_id) {
                    return back()->withInput()->with('error', "Mata pelajaran kejuruan '{$mapel->nama_mapel}' hanya dapat ditugaskan pada rombel dari jurusan yang sesuai.");
                }
            }
        }

        $skipped = [];
        $added = 0;

        foreach ($request->rombel_id as $rId) {
            // Cegah duplikasi penugasan mapel yang sama di rombel yang sama
            $exists = GuruMapel::where('mapel_id', $request->mapel_id)
                ->where('rombel_id', $rId)
                ->first();

            if ($exists) {
                $skipped[] = $rId;
                continue;
            }

            GuruMapel::create([
                'guru_id' => $request->guru_id,
                'mapel_id' => $request->mapel_id,
                'rombel_id' => $rId,
            ]);
            $added++;
        }

        if ($added == 0) {
            return back()->with('error', 'Semua mapel tersebut sudah ditugaskan kepada guru lain di rombel yang dipilih.');
        }

        $msg = "Berhasil menugaskan guru ke $added rombel.";
        if (count($skipped) > 0) {
            $msg .= " (Beberapa rombel dilewati karena sudah ada guru mapel tersebut).";
        }

        return redirect()->route('penugasan.guru-mapel')->with('success', $msg);
    }

    public function destroyGuruMapel(GuruMapel $guruMapel)
    {
        $guruMapel->delete();
        return redirect()->route('penugasan.guru-mapel')->with('success', 'Tugas Guru Mapel berhasil dicabut.');
    }

    public function apiRombels(Request $request)
    {
        $query = $request->input('q');

        $rombels = Rombel::with(['kelas', 'kelas.jurusan'])
            ->when($query, fn($builder) => $builder->where(function ($builder) use ($query) {
                $builder->where('tingkat', 'like', "%{$query}%")
                    ->orWhereHas('kelas', fn($kelas) => $kelas->where('tingkat', 'like', "%{$query}%")
                        ->orWhereHas('jurusan', fn($jurusan) => $jurusan->where('nama', 'like', "%{$query}%")));
            }))
            ->orderBy('tingkat')
            ->get()
            ->map(fn($rombel) => [
                'id' => $rombel->id,
                'text' => $rombel->label,
            ]);

        return response()->json($rombels);
    }

    public function apiGurus(Request $request)
    {
        $query = $request->input('q');
        $excludeWaliKelas = $request->boolean('exclude_wali_kelas');

        $gurus = Guru::when($query, function ($builder) use ($query) {
                $builder->search($query);
            })
            ->when($excludeWaliKelas, function ($builder) {
                $assignedGuruIds = WaliKelas::pluck('guru_id')->toArray();
                $builder->whereNotIn('id', $assignedGuruIds);
            })
            ->orderBy('nama', 'asc')
            ->take(20)
            ->get()
            ->map(fn($guru) => [
                'id' => $guru->id,
                'text' => $guru->nama,
            ]);

        return response()->json($gurus);
    }

    public function apiMapels(Request $request)
    {
        $query = $request->input('q');

        $mapels = Mapel::when($query, function ($builder) use ($query) {
                $builder->where('nama_mapel', 'like', "%{$query}%");
            })
            ->orderBy('nama_mapel', 'asc')
            ->take(20)
            ->get()
            ->map(fn($mapel) => [
                'id' => $mapel->id,
                'text' => $mapel->nama_mapel,
                'kelompok' => strtolower($mapel->kelompok ?? ''),
                'jurusan_id' => $mapel->jurusan_id ?? '',
            ]);

        return response()->json($mapels);
    }
}
