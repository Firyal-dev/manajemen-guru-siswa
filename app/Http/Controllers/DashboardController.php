<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Guru;
use App\Models\Siswa;
use App\Models\Jurusan;
use App\Models\Rombel;

class DashboardController extends Controller
{
    // Menampilkan halaman utama dashboard dengan statistik
    public function index()
    {
        $counts = [
            'guru' => Guru::count(),
            'siswa' => Siswa::count(),
            'jurusan' => Jurusan::count(),
            'rombel' => Rombel::count(),
        ];

        $siswaTerbaru = Siswa::with('riwayatKelas.rombel.kelas.jurusan')->latest()->take(5)->get();
        $guruTerbaru = Guru::latest()->take(5)->get();

        return view('dashboard', compact('counts', 'siswaTerbaru', 'guruTerbaru'));
    }
}
