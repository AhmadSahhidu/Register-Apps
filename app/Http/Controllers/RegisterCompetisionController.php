<?php

namespace App\Http\Controllers;

use App\Helpers\FlashData;
use App\Models\Anggota;
use App\Models\Competision;
use App\Models\RegisterCompetision;
use Illuminate\Http\Request;

class RegisterCompetisionController extends Controller
{
    public function index()
    {
        $competision = Competision::all();

        return view('pages.register.index', compact('competision'));
    }

    public function sessionRegister($competisionId)
    {
        $userRole = userRoleName();
        if ($userRole === 'Korda') {
            $kordaId = auth()->user()->korda_id;
            $anggota = Anggota::where('korda_id', $kordaId)->get();
        } else {
            $korwilId = auth()->user()->korwil_id;
            $anggota = Anggota::where('korwil_id', $korwilId)->get();
        }
        $competision = Competision::where('id', $competisionId)->first();

        return view('pages.register.session-register', compact('competision', 'anggota'));
    }

    public function process(Request $request, $competisionId)
    {
        try {
            $request->validate([
                'anggota_id' => 'required|string',
            ]);
            $userRole = userRoleName();
            if ($userRole === 'Korda') {
                $korwilId = auth()->user()->korda_id;
            } else {
                $korwilId = auth()->user()->korwil_id;
            }
            $competision = Competision::where('id', $competisionId)->first();
            $anggota = Anggota::where('id', $request->anggota_id)->first();
            $registerCompetisionSession = RegisterCompetision::where('competision_id', $competision->id)->where('no_group', 1)->where('korwil_id', $korwilId)->count();
            $anggotaRegisterValidation = RegisterCompetision::where('competision_id', $competision->id)->where('no_group', 1)->where('korwil_id', $korwilId)->where('anggota_id', $anggota->id)->count();
            $spaceKorwil = $competision->count_korwil_per_session * $competision->count_session;

            if ($registerCompetisionSession >= $spaceKorwil) {
                FlashData::danger_alert('Tempat pendaftaran anda sudah penuh');
                return redirect()->back();
            }

            if ($anggotaRegisterValidation > 0) {
                FlashData::danger_alert('Anggota ini sudah didaftarkan pada kompetisi ini');
                return redirect()->back();
            }

            RegisterCompetision::create([
                'number' => 'RCP-' . date('YmdHis'),
                'competision_id' => $competisionId,
                'no_session' => 0,
                'no_group' => 1,
                'name' => $request->name ? $request->name : null,
                'phone' => $request->phone ? $request->phone : null,
                'address' => $request->address ? $request->address : null,
                'anggota_id' => $anggota->id,
                'korwil_id' =>  $korwilId,
            ]);

            FlashData::success_alert('Berhasil mendaftarkan peserta lomba');
            return redirect()->route('register.index');
        } catch (\Throwable $th) {
            FlashData::danger_alert($th->getMessage());
            return redirect()->back();
        }
    }

    public function listPeserta($competisionId)
    {
        $korwilId = auth()->user()->korwil_id;
        $competision = Competision::where('id', $competisionId)->first();
        $registerCompetision = RegisterCompetision::with('anggota')->where('competision_id', $competision->id)->where('korwil_id', $korwilId)->orderBy('no_session', 'ASC')->get();

        return view('pages.register.list-peserta', compact('competision', 'registerCompetision'));
    }
}
