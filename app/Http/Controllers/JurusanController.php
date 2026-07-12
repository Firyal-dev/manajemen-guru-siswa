<?php

namespace App\Http\Controllers;

use App\Http\Requests\JurusanRequest;
use App\Models\Jurusan;

// Controller for Department (Jurusan) CRUD.
class JurusanController extends Controller
{
    // List all departments with nested relations (kelas → rombel → guru/siswa).
    public function index()
    {
        $jurusans = Jurusan::with(['kelas.rombel.guru', 'kelas.rombel.siswa'])->get();
        return view('kelas.index', compact('jurusans'));
    }

    // Show create department form.
    public function create()
    {
        return view('kelas.form-jurusan');
    }

    // Store new department.
    public function store(JurusanRequest $req)
    {
        Jurusan::create($req->validated());

        return redirect()->route('kelas')->with('success', 'Jurusan berhasil ditambahkan.');
    }
}
