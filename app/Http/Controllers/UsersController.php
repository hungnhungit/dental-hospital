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
            $q->where('TenDangNhap', 'LIKE', '%' . request('account') . '%');
        })->paginate(10);

        return Inertia::render('Users/List', [
            "users" => collect($users->items())->map(function (NhanVien $item) {
                return [
                    'id' => $item['Id'],
                    'full_name' => $item['HoVaTen'],
                    'dob' => $item['NgaySinh'],
                    'phone' => $item['DienThoai'],
                    'address' => $item['DiaChi'],
                    'account' => $item['taiKhoan']['TenDangNhap'],
                    'position' => $item['chucVu']['ChucVu'],
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

        $user = User::where('TenDangNhap', $request['username'])->first();
        if ($user) {
            throw ValidationException::withMessages(['message' => "DUPLICATE_USER"]);
        }

        $acc = User::create([
            'TenDangNhap' => $request['username'],
            'MatKhau' => Hash::make($request['password']),
            'QuyenId' => $request['role']
        ]);

        NhanVien::create(
            [
                'HoVaTen' => $request['fullName'],
                'NgaySinh' => $request['dob'],
                'DiaChi' => $request['address'],
                'MaChucVu' => $request['pos'],
                'MaTaiKhoan' => $acc['Id']
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
