<?php

namespace App\Http\Controllers;

use App\Http\Requests\GuruRequest;
use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

// CRUD controller for Teacher (Guru) management.
class GuruController extends Controller
{
    // List teachers with search & pagination.
    public function index(Request $req)
    {
        $gurus = Guru::search($req->search)
            ->paginate(10)
            ->withQueryString();

        return view('guru.index', compact('gurus'));
    }

    // Show create form.
    public function create()
    {
        return view('guru.form');
    }

    // Store new teacher with optional photo upload.
    public function store(GuruRequest $req)
    {
        $data = $req->validated();

        if ($req->hasFile('url_foto')) {
            $data['url_foto'] = $req->file('url_foto')->store('foto-guru', 'public');
        } else {
            $data['url_foto'] = null;
        }

        Guru::create($data);
        return redirect()->route('guru')->with('success', 'Guru berhasil ditambahkan.');
    }

    // Show edit form.
    public function edit(Guru $guru)
    {
        return view('guru.form', compact('guru'));
    }

    // Update teacher data; replace photo if new one uploaded.
    public function update(GuruRequest $req, Guru $guru)
    {
        $data = $req->validated();

        if ($req->hasFile('url_foto')) {
            if ($guru->url_foto) {
                Storage::disk('public')->delete($guru->url_foto);
            }
            $data['url_foto'] = $req->file('url_foto')->store('foto-guru', 'public');
        } else {
            unset($data['url_foto']);
        }

        $guru->update($data);
        return redirect()->route('guru')->with('success', 'Guru berhasil diperbarui.');
    }

    // Delete teacher and their photo.
    public function destroy(Guru $guru)
    {
        if ($guru->url_foto) {
            Storage::disk('public')->delete($guru->url_foto);
        }

        $guru->delete();
        return redirect()->route('guru')->with('success', 'Data guru berhasil dihapus.');
    }
}
