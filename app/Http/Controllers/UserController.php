<?php

namespace App\Http\Controllers;

use App\Helpers\FlashData;
use App\Models\Korda;
use App\Models\Korwil;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->get();
        return view('pages.users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        $korwil = Korwil::all();
        $korda = Korda::all();
        return view('pages.users.create', compact('roles', 'korwil', 'korda'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string',
                'password' => 'required|string',
                'password_confirm' => 'required|string|same:password',
                'username' => 'required|string',
                'role_id' => 'required',
            ]);
            // dd($request->korda_id);
            User::create([
                'name' => $request->name,
                'username' => $request->username,
                'password' => bcrypt($request->password),
                'role_id' => $request->role_id,
                'korwil_id' => $request->korwil_id != '' ? $request->korwil_id : null,
                'korda_id' => $request->korda_id != '' ? $request->korda_id : null,
            ]);

            FlashData::success_alert('Berhasil menambahkan pengguna baru');
            return redirect()->route('users.index');
        } catch (\Throwable $th) {
            FlashData::danger_alert($th->getMessage());
            return redirect()->back();
        }
    }

    public function edit($userId)
    {
        $user = User::where('id', $userId)->first();
        return view('pages.users.edit', compact('user'));
    }

    public function update(Request $request, $userId)
    {
        try {
            $request->validate([
                'name' => 'required',
                'username' => 'required'
            ]);

            $cekSetPassword = $request->cek_setpassword;
            if ($cekSetPassword) {
                if ($request->password != $request->password_confirm) {
                    FlashData::danger_alert('Konfirmasi password tidak sama dengan password');
                    return redirect()->back();
                }

                User::where('id', $userId)->update([
                    'name' => $request->name,
                    'username' =>  $request->username,
                    'password' => $request->password,
                ]);
            } else {
                User::where('id', $userId)->update([
                    'name' => $request->name,
                    'username' => $request->username
                ]);
            }

            FlashData::success_alert('Berhasil merubah data pengguna');
            return redirect()->route('users.index');
        } catch (\Throwable $th) {
            FlashData::danger_alert($th->getMessage());
            return redirect()->back();
        }
    }

    public function usersDelete(Request $request)
    {
        $userId = $request->userId;
        User::where('id', $userId)->delete();
    }
}
