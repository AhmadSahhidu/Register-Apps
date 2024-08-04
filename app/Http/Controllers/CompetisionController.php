<?php

namespace App\Http\Controllers;

use App\Helpers\FlashData;
use App\Models\Competision;
use App\Models\Korwil;
use App\Models\RegisterCompetision;
use App\Models\RequestRegisterCompetision;
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
            FlashData::danger_alert($th->getMessage());
            return redirect()->back();
        }
    }

    public function delete(Request $request)
    {
        $competisionId = $request->competisionId;
        Competision::where('id', $competisionId)->delete();
    }

    public function peserta($competisionId)
    {
        $competision = Competision::where('id', $competisionId)->first();
        $dataQuery = RegisterCompetision::query();
        $dataQuery->select('register_competisions.*', 'anggotas.name as anggota_name', 'anggotas.phone as anggota_phone', 'anggotas.address as anggota_address');

        $dataQuery->join('anggotas', 'anggotas.id', '=', 'register_competisions.anggota_id');
        $peserta = $dataQuery->get();
        return view('pages.competision.peserta.index', compact('peserta', 'competision'));
    }

    public function setSessionPeserta($competisionId)
    {
        $competision = Competision::where('id', $competisionId)->first();
        $peserta = RegisterCompetision::with('anggota')->where('competision_id', $competision->id)->where('no_group', 1)->get();

        foreach ($peserta as $items) {
            // Cek apakah anggota berasal dari korwil atau korda
            $regionId = null;
            if ($items->anggota->korwil_id !== null) {
                $regionId = $items->anggota->korwil_id;
            } else if ($items->anggota->korda_id !== null) {
                $regionId = $items->anggota->korda_id;
            }

            if ($regionId !== null) {
                // Ambil peserta berdasarkan regionId yang dihasilkan dari pengecekan
                $pesertaRegion = RegisterCompetision::where('competision_id', $competision->id)
                    ->where('korwil_id', $regionId)
                    ->where('no_group', 1)
                    ->get();

                // Bagi peserta ke dalam sesi berdasarkan count_korwil_per_session
                $sessionPesertaChunks = $pesertaRegion->chunk($competision->count_korwil_per_session);

                foreach ($sessionPesertaChunks as $sessionNumber => $chunk) {
                    foreach ($chunk as $data) {
                        RegisterCompetision::where('id', $data->id)->update(['no_session' => $sessionNumber + 1]);
                    }
                }
            }
        }

        FlashData::success_alert('Berhasil mengatur sesi');
        return redirect()->back();
    }

    public function pesertaTambahan($competisionId)
    {
        $competision = Competision::where('id', $competisionId)->first();
        $dataQuery = RequestRegisterCompetision::query();
        $dataQuery->select('request_register_competisions.*', 'anggotas.name as anggota_name', 'anggotas.phone as anggota_phone', 'anggotas.address as anggota_address');

        $dataQuery->join('anggotas', 'anggotas.id', '=', 'request_register_competisions.anggota_id');
        $peserta = $dataQuery->get();
        return view('pages.competision.peserta.peserta-tambahan', compact('peserta', 'competision'));
    }

    public function importGelombangOne($pesertaId)
    {
        try {
            $peserta = RequestRegisterCompetision::where('id', $pesertaId)->first();
            $competision = Competision::where('id', $peserta->competision_id)->first();
            $validationPesertaImport = RegisterCompetision::where('competision_id', $peserta->competision_id)->where('korwil_id', $peserta->korwil_id)->where('anggota_id', $peserta->anggota_id)->count();
            if ($validationPesertaImport > 0) {
                FlashData::danger_alert('Peserta ini sudah didaftarkan pada gelombang 1');
                return redirect()->back();
            }

            $saved = false;
            for ($i = 0; $i < $competision->count_session; $i++) {
                $validationSesi = RegisterCompetision::where('no_session', $i + 1)
                    ->where('competision_id', $competision->id)
                    ->count();

                if ($validationSesi < $competision->count_gantangan) {
                    // Tambahkan randomisasi untuk nomor
                    $uniqueNumber = 'RCP-' . date('YmdHis') . '-' . uniqid();

                    RegisterCompetision::create([
                        'competision_id' => $competision->id,
                        'number' => $uniqueNumber,
                        'no_session' => $i + 1,
                        'no_group' => 1,
                        'name' => $peserta->name,
                        'phone' => $peserta->phone,
                        'address' => $peserta->address,
                        'anggota_id' => $peserta->anggota_id,
                        'korwil_id' => $peserta->korwil_id
                    ]);

                    $saved = true;
                    break;
                }
            }

            if ($saved) {
                RequestRegisterCompetision::where('id', $peserta->id)->delete();
                FlashData::success_alert('Request anda berhasil');
                return redirect()->route('competision.list-peserta', $competision->id);
            } else {
                FlashData::danger_alert('Semua sesi sudah penuh');
                return redirect()->back();
            }
        } catch (\Throwable $th) {
            FlashData::danger_alert($th->getMessage());
            return redirect()->back();
        }
    }

    public function closeRegister($competisionId)
    {
        Competision::where('id', $competisionId)->update([
            'status' =>  1,
        ]);

        FlashData::success_alert('Berhasil menutup pendaftaran');
        return redirect()->back();
    }

    public function deletePesertaTambahan(Request $request)
    {
        RequestRegisterCompetision::where('id', $request->pesertaId)->delete();
        FlashData::success_alert('Berhasil menghapus data peserta');
        return redirect()->back();
    }

    public function deletePeserta(Request $request)
    {
        RegisterCompetision::where('id', $request->pesertaId)->delete();
        FlashData::success_alert('Berhasil menghapus data peserta');
        return redirect()->back();
    }

    public function importAllPesertaTambahan(Request $request, $competisionId)
    {
        try {
            $pesertaList = RequestRegisterCompetision::where('competision_id', $competisionId)->get();
            $competision = Competision::where('id', $competisionId)->first();
            $savedCount = 0;

            foreach ($pesertaList as $data) {
                $saved = false;

                for ($i = 0; $i < $competision->count_session; $i++) {
                    $validationSesi = RegisterCompetision::where('no_session', $i + 1)
                        ->where('competision_id', $competision->id)
                        ->count();

                    if ($validationSesi < $competision->count_gantangan) {
                        RegisterCompetision::create([
                            'name' => $data->name,
                            'phone' => $data->phone,
                            'address' => $data->address,
                            'anggota_id' => $data->anggota_id,
                            'korwil_id' => $data->korwil_id,
                            'no_group' => $competision->group + 1,
                            'competision_id' => $competisionId,
                            'no_session' => $i + 1,
                            'number' => 'RCP-' . date('YmdHis') . '-' . uniqid()
                        ]);

                        // Tandai peserta sebagai sudah disimpan
                        $saved = true;
                        $savedCount++;
                        break;
                    }
                }

                if ($saved) {
                    // Hapus peserta dari RequestRegisterCompetision setelah disimpan
                    RequestRegisterCompetision::where('id', $data->id)->delete();
                    Competision::where('id', $competision->id)->update(['group' => $competision->group + 1]);
                }
            }

            if ($savedCount > 0) {
                FlashData::success_alert('Request anda berhasil, total peserta yang disimpan: ' . $savedCount);
            } else {
                FlashData::danger_alert('Semua sesi sudah penuh');
            }

            return redirect()->route('competision.list-peserta', $competision->id);
        } catch (\Throwable $th) {
            FlashData::danger_alert($th->getMessage());
            return redirect()->back();
        }
    }
}
