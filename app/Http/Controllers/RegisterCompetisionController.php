<?php

namespace App\Http\Controllers;

use App\Helpers\FlashData;
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
        $competision = Competision::where('id', $competisionId)->first();

        return view('pages.register.session-register', compact('competision'));
    }

    public function process(Request $request, $competisionId)
    {
        try {
            $request->validate([
                'name' => 'required|string',
                'phone' => 'required|string',
                'address' => 'required|string'
            ]);
            $korwilId = auth()->user()->korwil_id;
            $competision = Competision::where('id', $competisionId)->first();
            $registerCompetisionSession = RegisterCompetision::where('competision_id', $competision->id)->where('korwil_id', $korwilId)->count();
            $spaceKorwil = $competision->count_korwil_per_session * $competision->count_session;

            if ($registerCompetisionSession >= $spaceKorwil) {
                FlashData::danger_alert('Tempat pendaftaran anda sudah penuh');
                return redirect()->back();
            }
            $userRole = userRoleName();
            RegisterCompetision::create([
                'number' => 'RCP-' . date('YmdHis'),
                'competision_id' => $competisionId,
                'no_session' => 0,
                'no_group' => 1,
                'name' => $request->name,
                'phone' => $request->phone,
                'address' => $request->address,
                'korwil_id' => $userRole === 'Super Admin' ? null : $korwilId,
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
        $registerCompetision = RegisterCompetision::where('competision_id', $competision->id)->where('korwil_id', $korwilId)->orderBy('no_session', 'ASC')->get();

        return view('pages.register.list-peserta', compact('competision', 'registerCompetision'));
    }
}
