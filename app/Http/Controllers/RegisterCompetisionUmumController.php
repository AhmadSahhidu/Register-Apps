<?php

namespace App\Http\Controllers;

use App\Helpers\FlashData;
use App\Models\Competision;
use App\Models\RegisterCompetision;
use Illuminate\Http\Request;

class RegisterCompetisionUmumController extends Controller
{
    public function index()
    {
        $competision = Competision::all();

        return view('pages.register.peserta-umum', compact('competision'));
    }

    public function create($competisionId)
    {
        $competision = Competision::where('id', $competisionId)->first();
        return view('pages.register.register-umum', compact('competision'));
    }

    public function store(Request $request, $competisionId)
    {
        try {
            $competision = Competision::where('id', $competisionId)->first();


            $validationSesi = RegisterCompetision::where('no_session', $request->session)
                ->where('competision_id', $competision->id)
                ->count();

            if ($validationSesi < $competision->count_gantangan) {
                // Tambahkan randomisasi untuk nomor
                $uniqueNumber = 'RCP-' . date('YmdHis') . '-' . uniqid();

                RegisterCompetision::create([
                    'competision_id' => $competision->id,
                    'number' => $uniqueNumber,
                    'no_session' => $request->session,
                    'no_group' => 1,
                    'name' => $request->name,
                    'phone' => $request->phone,
                    'address' => $request->address,
                ]);
            } else {
                FlashData::danger_alert('Sesi ' . $request->session . ' sudah penuh');
                return redirect()->back();
            }


            FlashData::success_alert('Request anda berhasil');
            return redirect()->route('register.register_umum');
        } catch (\Throwable $th) {
            FlashData::danger_alert($th->getMessage());
            return redirect()->back();
        }
    }
}
