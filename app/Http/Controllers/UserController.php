<?php

namespace App\Http\Controllers;

use App\Helpers\FlashData;
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
        return view('pages.users.create', compact('roles', 'korwil'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string',
                'password' => 'required|min:6|string',
                'password_confirm' => 'required|string|same:password',
                'username' => 'required|string',
                'role_id' => 'required',
            ]);

            User::create([
                'name' => $request->name,
                'username' => $request->username,
                'password' => bcrypt($request->password),
                'role_id' => $request->role_id,
                'korwil_id' => $request->korwil_id != '' ? $request->korwil_id : null,
            ]);

            FlashData::success_alert('Berhasil menambahkan pengguna baru');
            return redirect()->route('users.index');
        } catch (\Throwable $th) {
            FlashData::danger_alert($th->getMessage());
            return redirect()->back();
        }
    }
}
