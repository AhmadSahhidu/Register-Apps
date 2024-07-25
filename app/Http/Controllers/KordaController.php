<?php

namespace App\Http\Controllers;

use App\Helpers\FlashData;
use App\Models\Anggota;
use App\Models\Korda;
use Illuminate\Http\Request;

class KordaController extends Controller
{
    public function index()
    {
        $korda = Korda::all();
        return view('pages.korda.index', compact('korda'));
    }

    public function create()
    {
        return view('pages.korda.create');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'code' => 'required|string',
                'name' => 'required|string'
            ]);
            Korda::create([
                'name' => $request->name,
                'code' => $request->code
            ]);

            FlashData::success_alert('Berhasil menambahkan data koordinasi daerah');
            return redirect()->route('korda.index');
        } catch (\Throwable $th) {
            FlashData::danger_alert($th->getMessage());
            return redirect()->back();
        }
    }

    public function show($kordaId)
    {
        $korda = Korda::where('id', $kordaId)->first();

        return view('pages.korda.edit', compact('korda'));
    }

    public function update(Request $request, $kordaId)
    {
        try {
            $request->validate([
                'code' => 'required|string',
                'name' => 'required|string'
            ]);
            Korda::where('id', $kordaId)->update([
                'name' => $request->name,
                'code' => $request->code
            ]);

            FlashData::success_alert('Berhasil merubah data koordinasi daerah');
            return redirect()->route('korda.index');
        } catch (\Throwable $th) {
            FlashData::danger_alert($th->getMessage());
            return redirect()->back();
        }
    }

    public function delete(Request $request)
    {
        $kordaId = $request->kordaId;
        Korda::where('id', $kordaId)->delete();
    }

    public function anggotaKorda($kordaId)
    {
        $anggota = Anggota::with('korda')->where('korda_id', $kordaId)->get();
        $korda = Korda::where('id', $kordaId)->first();
        return view('pages.anggota.korda.index', compact('anggota', 'korda'));
    }
}
