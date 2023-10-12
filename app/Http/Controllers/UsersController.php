<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\NhanVien;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class UsersController extends Controller
{
    public function index()
    {
        $users = NhanVien::query()->with(['taiKhoan', 'chucVu'])->whereHas('taiKhoan', function (Builder $q) {
            $q->where('TenTaiKhoan', 'LIKE', '%' . request('account') . '%');
        })->paginate(10);

        return Inertia::render('Users/List', [
            "users" => collect($users->items())->map(function (NhanVien $item) {
                return [
                    'id' => $item['idNV'],
                    'full_name' => $item['HoVaTen'],
                    'dob' => $item['NgaySinh'],
                    'phone' => $item['DienThoai'],
                    'address' => $item['DiaChi'],
                    'account' => $item['taiKhoan']['TenTaiKhoan'],
                    'position' => $item['chucVu']['TenChucVu'],
                ];
            }),
            "totalPage" => $users->total(),
        ]);
    }

    public function new(Request $request)
    {
        return Inertia::render('Users/New');
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => ['required'],
            'password' => ['required']
        ]);

        $user = User::where('TenTaiKhoan', $request['username'])->first();
        if ($user) {
            throw ValidationException::withMessages(['message' => "DUPLICATE_USER"]);
        }

        $acc = User::create([
            'TenTaiKhoan' => $request['username'],
            'MatKhau' => Hash::make($request['password']),
            'PhanQuyenId' => $request['role']
        ]);

        NhanVien::create(
            [
                'HoVaTen' => $request['fullName'],
                'DienThoai' => $request['phone'],
                'NgaySinh' => $request['dob'],
                'DiaChi' => $request['address'],
                'ChucVuId' => $request['pos'],
                'TaiKhoanId' => $acc['idTK']
            ]
        );

        return redirect('/taikhoan');
    }

    public function destroy(Request $request)
    {
        NhanVien::destroy($request['id']);

        return redirect('/taikhoan');
    }
}
