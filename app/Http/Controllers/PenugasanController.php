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
        $gurus = Guru::orderBy('nama', 'asc')->get();
        $rombels = Rombel::with('kelas')->get();
        
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
        $gurus = Guru::orderBy('nama', 'asc')->get();
        $mapels = Mapel::orderBy('nama_mapel', 'asc')->get();
        $rombels = Rombel::with('kelas')->get();

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
}
