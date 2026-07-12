<?php

namespace App\Http\Controllers;

use App\Http\Requests\TahunAjaranRequest;
use App\Models\TahunAjaran;

// Controller for academic year CRUD & activation.
class TahunAjaranController extends Controller
{
    // Create a new academic year.
    public function store(TahunAjaranRequest $req)
    {
        TahunAjaran::create($req->validated());
        return redirect()->back()->with('success', 'Berhasil membuat tahun ajaran baru!');
    }

    // Update an existing academic year.
    public function update(TahunAjaranRequest $req, TahunAjaran $ta)
    {
        $ta->update($req->validated());
        return redirect()->back()->with('success', 'Berhasil mengedit tahun ajaran baru!');
    }

    // Set an academic year as active (deactivates others).
    public function active(TahunAjaran $ta)
    {
        $ta = TahunAjaran::active($ta->id);
        return back()->with('success', "Tahun ajaran {$ta->nama} berhasil diaktifkan.");
    }
}
