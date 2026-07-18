<?php

namespace App\Http\Controllers;

use App\Http\Requests\MapelRequest;
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
            ->where('status', 1)
            ->orderBy('nama_mapel')
            ->paginate(10)
            ->withQueryString();

        return view('mapel.index', compact('mapels'));
    }

    public function create()
    {
        return view('mapel.form');
    }

    public function store(MapelRequest $request)
    {
        $data = $request->validated();
        $data['status'] = 1;
        Mapel::create($data);

        return redirect()->route('mapel.index')->with('success', 'Mapel berhasil ditambahkan.');
    }

    public function edit(Mapel $mapel)
    {
        return view('mapel.form', compact('mapel'));
    }

    public function update(MapelRequest $request, Mapel $mapel)
    {
        $mapel->update($request->validated());

        return redirect()->route('mapel.index')->with('success', 'Mapel berhasil diperbarui.');
    }

    public function destroy(Mapel $mapel)
    {
        $mapel->update(['status' => 2]);

        return redirect()->route('mapel.index')->with('success', 'Mapel berhasil dihapus.');
    }
}
