<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PhanQuyen;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class RoleController extends Controller
{
    public function index()
    {
        $roles = PhanQuyen::query()->get();

        return Inertia::render('Role/List', [
            "roles" => $roles->map(function ($item) {
                return [
                    "id" => $item['Id'],
                    "Quyen" => $item['Quyen'],
                ];
            }),
        ]);
    }

    public function show(int $id)
    {
        $role = PhanQuyen::query()->with('ham')->findOrFail($id);

        return Inertia::render('Role/Settings', ['role' => $role->toArray(), 'permssions' => collect($role->ham)->map(function ($item) {
            return [
                'id' => $item['Id'],
                'permission' => $item['TenHam'],
                'on' => boolval($item['payload']['on'])
            ];
        })]);
    }

    public function update(int $id, Request $request)
    {
        $role = PhanQuyen::query()->findOrFail($id);
        $permissionsOn = $request['permissionsOn'];
        $permissionsOff = $request['permissionsOff'];
        DB::table('phanquyenham')->where('PhanQuyenId', $role['Id'])->whereIn('HamId', Arr::pluck($permissionsOn, 'id'))->update(['on' => 1]);
        DB::table('phanquyenham')->where('PhanQuyenId', $role['Id'])->whereIn('HamId', Arr::pluck($permissionsOff, 'id'))->update(['on' => 0]);



        return back();
    }
}
