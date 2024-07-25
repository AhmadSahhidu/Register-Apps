<?php

namespace App\Http\Controllers;

use App\Helpers\FlashData;
use App\Models\Anggota;
use App\Models\Competision;
use App\Models\RequestRegisterCompetision;
use Illuminate\Http\Request;

class RequestRegisterCompetisionController extends Controller
{
    public function formRequest($competisionId)
    {
        $korwilId = auth()->user()->korwil_id;
        $competision = Competision::where('id', $competisionId)->first();
        $anggota = Anggota::where('korwil_id', $korwilId)->get();
        return view('pages.register.request-peserta', compact('competision', 'anggota'));
    }

    public function prosesRegisterAdd(Request $request, $competisionId)
    {
        try {
            $request->validate([
                'anggota_id' => 'string|required'
            ]);
            $usurRole = userRoleName();
            if ($usurRole === 'Korda') {
                $korwilId = auth()->user()->korda_id;
            } else {
                $korwilId = auth()->user()->korwil_id;
            }
            $anggota = Anggota::where('id', $request->anggota_id)->first();
            $anggotaRegisterValidation = RequestRegisterCompetision::where('competision_id', $competisionId)->where('korwil_id', $korwilId)->where('anggota_id', $anggota->id)->count();

            if ($anggotaRegisterValidation > 0) {
                FlashData::danger_alert('Anggota ini sudah ditambahkan pada peserta tambahan dikompetisi ini');
                return redirect()->back();
            }
            RequestRegisterCompetision::create([
                'anggota_id' => $request->anggota_id,
                'competision_id' => $competisionId,
                'korwil_id' => $korwilId
            ]);

            FlashData::success_alert('Berhasil mengirim peserta tambahan');
            return redirect()->route('register.index');
        } catch (\Throwable $th) {
            FlashData::danger_alert($th->getMessage());
            return redirect()->back();
        }
    }
}
