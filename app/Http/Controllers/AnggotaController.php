<?php

namespace App\Http\Controllers;

use App\Helpers\FlashData;
use App\Models\Anggota;
use App\Models\Korwil;
use App\Models\RegisterCompetision;
use App\Models\RequestRegisterCompetision;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AnggotaController extends Controller
{
    public function index()
    {
        $userRole = userRoleName();
        if ($userRole === 'Korda') {
            $kordaId = auth()->user()->korda_id;
            $anggota = Anggota::with('korda')->where('korda_id', $kordaId)->get();
        } else {
            $korwilId = auth()->user()->korwil_id;
            $anggota = Anggota::with('korwil')->where('korwil_id', $korwilId)->get();
        }
        error_log('anggota: ' . $korwilId);

        return view('pages.anggota.index', compact('anggota'));
    }

    public function create()
    {
        $korwilId = auth()->user()->korwil_id;
        $korwil = Korwil::where('id', $korwilId)->first();
        // error_log('sdsd' . $korwilId);
        return view('pages.anggota.create', compact('korwil'));
    }

    public function store(Request $request)
    {
        try {

            $validated = $request->validate([
                'name' => 'required|string',
                'phone' => 'required',
                'photo' => 'required|image|mimes:png,jpg,jpeg',
                'address' => 'required|string',
            ]);
            $userRole = userRoleName();

            if ($userRole === 'Korda') {
                $id = auth()->user()->korda_id;
                $validated['korda_id'] = $id;
            } else {
                $id = auth()->user()->korwil_id;
                $validated['korwil_id'] = $id;
            }
            $validated['number'] = 'PST' . date('YmdHis');

            if ($request->hasFile('photo')) {
                // put image in the public storage
                $filePath = Storage::disk('public')->put('images/anggota/photo', request()->file('photo'));
                $validated['photo'] = $filePath;
            }


            $create = Anggota::create($validated);
            if ($create) {
                // add flash for the success notification
                FlashData::success_alert('Berhasil menambahkan anggota baru');
                return redirect()->route('anggota.index');
            }

            return abort(500);
        } catch (\Throwable $th) {
            FlashData::danger_alert($th->getMessage());
            return redirect()->back();
        }
    }

    public function edit($anggotaId)
    {
        $anggota = Anggota::where('id', $anggotaId)->first();

        return view('pages.anggota.edit', compact('anggota'));
    }

    public function update(Request $request, $anggotaId)
    {
        try {

            $userRole = userRoleName();
            $anggota = Anggota::where('id', $anggotaId)->first();
            $validated = $request->validate([
                'name' => 'required|string',
                'phone' => 'required',
                'address' => 'required|string',
            ]);
            if ($request->hasFile('photo')) {
                // put image in the public storage
                $filePath = Storage::disk('public')->put('images/anggota/photo', request()->file('photo'));
                $validated['photo'] = $filePath;
                Storage::disk('public')->delete($anggota->photo);
            }

            $update = Anggota::where('id', $anggota->id)->update($validated);
            if ($update) {
                // add flash for the success notification
                FlashData::success_alert('Berhasil merubah data anggota');
                if ($userRole === 'Super Admin') {
                    return redirect()->route('korwil.anggota', $anggota->korwil_id);
                } else {
                    return redirect()->route('anggota.index');
                }
            }

            return abort(500);
        } catch (\Throwable $th) {
            FlashData::danger_alert($th->getMessage());
            return redirect()->back();
        }
    }

    public function delete(Request $request)
    {
        $anggotaId = $request->anggotaId;
        $anggota = Anggota::where('id', $anggotaId)->first();
        RegisterCompetision::where('anggota_id', $anggota->id)->delete();
        Storage::disk('public')->delete($anggota->photo);
        RequestRegisterCompetision::where('anggota_id', $anggota->id)->delete();

        Anggota::where('id', $anggota->id)->delete();
    }
}
