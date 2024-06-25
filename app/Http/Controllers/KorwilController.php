<?php

namespace App\Http\Controllers;

use App\Helpers\FlashData;
use App\Models\Korwil;
use Illuminate\Http\Request;

class KorwilController extends Controller
{
    public function index()
    {
        $korwil = Korwil::all();
        return view('pages.korwil.index', compact('korwil'));
    }

    public function create()
    {
        return view('pages.korwil.create');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'code' => 'required|string',
                'name' => 'required|string'
            ]);
            Korwil::create([
                'name' => $request->name,
                'code' => $request->code
            ]);

            FlashData::success_alert('Berhasil menambahkan data korwil');
            return redirect()->route('korwil.index');
        } catch (\Throwable $th) {
            FlashData::danger_alert($th->getMessage());
            return redirect()->back();
        }
    }

    public function show($korwilId)
    {
        $korwil = Korwil::where('id', $korwilId)->first();

        return view('pages.korwil.edit', compact('korwil'));
    }

    public function update(Request $request, $korwilId)
    {
        try {
            $request->validate([
                'code' => 'required|string',
                'name' => 'required|string'
            ]);
            Korwil::where('id', $korwilId)->update([
                'name' => $request->name,
                'code' => $request->code
            ]);

            FlashData::success_alert('Berhasil merubah data korwil');
            return redirect()->route('korwil.index');
        } catch (\Throwable $th) {
            FlashData::danger_alert($th->getMessage());
            return redirect()->back();
        }
    }

    public function delete(Request $request)
    {
        $korwilId = $request->korwilId;
        Korwil::where('id', $korwilId)->delete();
    }
}
