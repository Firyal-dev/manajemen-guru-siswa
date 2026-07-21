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
        return view('jurusan.form');
    }

    // Store new department.
    public function store(JurusanRequest $req)
    {
        Jurusan::create($req->validated());

        return redirect()->route('jurusan.index')->with('success', 'Jurusan berhasil ditambahkan.');
    }

    // Dedicated department management page (list + row counts).
    public function manage()
    {
        $jurusans = Jurusan::withCount(['kelas', 'mapels'])
            ->orderBy('nama')
            ->paginate(10);

        return view('jurusan.index', compact('jurusans'));
    }

    // Show edit form.
    public function edit(Jurusan $jurusan)
    {
        return view('jurusan.form', compact('jurusan'));
    }

    // Update department.
    public function update(JurusanRequest $req, Jurusan $jurusan)
    {
        $jurusan->update($req->validated());

        return redirect()->route('jurusan.index')->with('success', 'Jurusan berhasil diperbarui.');
    }

    // Delete department (blocked when still referenced by kelas/mapel).
    public function destroy(Jurusan $jurusan)
    {
        if ($jurusan->kelas()->exists() || $jurusan->mapels()->exists()) {
            return redirect()->route('jurusan.index')
                ->with('error', 'Jurusan tidak dapat dihapus karena masih dipakai kelas atau mapel.');
        }

        $jurusan->delete();

        return redirect()->route('jurusan.index')->with('success', 'Jurusan berhasil dihapus.');
    }
}
