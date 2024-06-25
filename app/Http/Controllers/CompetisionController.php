<?php

namespace App\Http\Controllers;

use App\Helpers\FlashData;
use App\Models\Competision;
use Illuminate\Http\Request;

class CompetisionController extends Controller
{
    public function index()
    {
        $competision = Competision::all();

        return view('pages.competision.index', compact('competision'));
    }

    public function create()
    {
        return view('pages.competision.create');
    }

    public function store(Request $request)
    {
        try {
            $countgantangan = $request->count_gantangan;
            $countkorwil = $request->count_korwil;
            $countkorwilPerSession = floor($countgantangan / $countkorwil);
            $countGantanganKorwilPerSession = $countkorwil * $countkorwilPerSession;
            $countMore = $countgantangan - $countGantanganKorwilPerSession;

            Competision::create([
                'number' => 'CPS' . date('YmdHis'),
                'name' => $request->name,
                'tgl' => $request->tgl,
                'count_session' => $request->count_session,
                'count_gantangan' => $request->count_gantangan,
                'count_korwil' => $request->count_korwil,
                'count_korwil_per_session' => $countkorwilPerSession,
                'count_more_per_session' => $countMore
            ]);

            FlashData::success_alert('Berhasil menambahkan kompetisi baru');
            return redirect()->route('competision.index');
        } catch (\Throwable $th) {
            FlashData::danger_alert($th->getMessage());
            return redirect()->back();
        }
    }

    public function edit($competisionId)
    {
        $competision = Competision::where('id', $competisionId)->first();

        return view('pages.competision.edit', compact('competision'));
    }

    public function update(Request $request, $competisionId)
    {
        try {
            $countgantangan = $request->count_gantangan;
            $countkorwil = $request->count_korwil;
            $countkorwilPerSession = floor($countgantangan / $countkorwil);
            $countGantanganKorwilPerSession = $countkorwil * $countkorwilPerSession;
            $countMore = $countgantangan - $countGantanganKorwilPerSession;

            Competision::where('id', $competisionId)->update([
                'name' => $request->name,
                'tgl' => $request->tgl,
                'count_session' => $request->count_session,
                'count_gantangan' => $request->count_gantangan,
                'count_korwil' => $request->count_korwil,
                'count_korwil_per_session' => $countkorwilPerSession,
                'count_more_per_session' => $countMore
            ]);

            FlashData::success_alert('Berhasil merubah data kompetisi');
            return redirect()->route('competision.index');
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
