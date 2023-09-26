<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\NhanVien;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;
use Role;

class UsersController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Users/List');
    }

    public function paginate(Request $request)
    {
        $users = NhanVien::query()->with(['taiKhoan', 'chucVu'])->paginate(10);

        return [
            "users" => collect($users->items())->map(function (NhanVien $item) {
                return [
                    'full_name' => $item['HoVaTen'],
                    'dob' => $item['NgaySinh'],
                    'phone' => $item['DienThoai'],
                    'address' => $item['DiaChi'],
                    'account' => $item['taiKhoan']['TenTaiKhoan'],
                    'position' => $item['chucVu']['TenChucVu'],
                ];
            }),
            "totalPage" => $users->total(),
        ];
    }

    public function new(Request $request)
    {
        return Inertia::render('Users/New');
    }

    public function destroy(Request $request)
    {
        User::destroy($request->id);

        return true;
    }
}
