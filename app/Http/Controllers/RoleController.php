<?php

namespace App\Http\Controllers;

use App\Helpers\FlashData;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();

        return view('pages.roles.index', compact('roles'));
    }

    public function create()
    {
        return view('pages.roles.create');
    }

    public function store(Request $request)
    {
        try {
            $request->validate(['name' => 'required|string']);
            Role::create(['name' => $request->name]);

            FlashData::success_alert('Berhasil menambahkan role baru');
            return redirect()->route('roles.index');
        } catch (\Throwable $th) {
            FlashData::danger_alert($th->getMessage());
            return redirect()->back();
        }
    }

    public function edit($roleId)
    {
        $role = Role::where('id', $roleId)->first();

        return view('pages.roles.edit', compact('role'));
    }

    public function update(Request $request, $roleId)
    {
        try {
            $request->validate(['name' => 'required|string']);

            Role::where('id', $roleId)->update(['name' => $request->name]);

            FlashData::success_alert('Berhasil merubah data role');
            return redirect()->route('roles.index');
        } catch (\Throwable $th) {
            FlashData::danger_alert($th->getMessage());
            return redirect()->back();
        }
    }

    public function delete(Request $request)
    {
        $roleId = $request->roleId;

        Role::where('id', $roleId)->delete();
    }
}
