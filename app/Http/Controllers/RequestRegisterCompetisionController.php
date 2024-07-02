<?php

namespace App\Http\Controllers;

use App\Helpers\FlashData;
use App\Models\Competision;
use App\Models\RequestRegisterCompetision;
use Illuminate\Http\Request;

class RequestRegisterCompetisionController extends Controller
{
    public function formRequest($competisionId)
    {
        $competision = Competision::where('id', $competisionId)->first();
        return view('pages.register.request-peserta', compact('competision'));
    }

    public function prosesRegisterAdd(Request $request, $competisionId)
    {
        try {
            $request->validate([
                'name' => 'string|required',
                'phone' => 'string|required',
                'address' => 'string|required'
            ]);
            $korwilId = auth()->user()->korwil_id;
            RequestRegisterCompetision::create([
                'name' => $request->name,
                'phone' => $request->phone,
                'address' => $request->address,
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
