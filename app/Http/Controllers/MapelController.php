<?php

namespace App\Http\Controllers;

use App\Http\Requests\MapelRequest;
use App\Models\Jurusan;
use App\Models\Mapel;
use Illuminate\Http\Request;

class MapelController extends Controller
{
    public function index(Request $request)
    {
        return $this->caridata($request);
    }

    public function caridata(Request $request)
    {
        $mapels = Mapel::search($request->search)
            ->with('jurusan')
            ->orderBy('nama_mapel')
            ->paginate(10)
            ->withQueryString();

        return view('mapel.index', compact('mapels'));
    }

    public function create()
    {
        $jurusans = Jurusan::orderBy('nama')->get();

        return view('mapel.form', compact('jurusans'));
    }

    public function store(MapelRequest $request)
    {
        Mapel::create($request->validated());

        return redirect()->route('mapel.index')->with('success', 'Mapel berhasil ditambahkan.');
    }

    public function edit(Mapel $mapel)
    {
        $jurusans = Jurusan::orderBy('nama')->get();

        return view('mapel.form', compact('mapel', 'jurusans'));
    }

    public function update(MapelRequest $request, Mapel $mapel)
    {
        $mapel->update($request->validated());

        return redirect()->route('mapel.index')->with('success', 'Mapel berhasil diperbarui.');
    }

    public function destroy(Mapel $mapel)
    {
        $mapel->delete();

        return redirect()->route('mapel.index')->with('success', 'Mapel berhasil dihapus.');
    }
}
