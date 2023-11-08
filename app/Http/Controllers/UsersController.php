<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\NhanVien;
use App\Models\User;
use Carbon\Carbon;
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
                    'dob' => Carbon::parse($item['NgaySinh'])->format('d/m/Y'),
                    'phone' => $item['DienThoai'],
                    'address' => $item['DiaChi'],
                    'account' => $item['taiKhoan']['TenDangNhap'],
                    'position' => $item['chucVu']['ChucVu'],
                ];
            }),
            "totalPage" => $users->total(),
        ]);
    }

    public function create(Request $request)
    {
        return Inertia::render('Users/New');
    }

    public function edit(int $id)
    {
        $user = NhanVien::query()->with(['taiKhoan'])->findOrFail($id);

        return Inertia::render('Users/New', [
            'user' => [
                'id' => $user['Id'],
                'username' => $user['taiKhoan']['TenDangNhap'],
                'role' => $user['taiKhoan']['QuyenId'],
                'fullName' => $user['HoVaTen'],
                'dob' => $user['NgaySinh'],
                'address' => $user['DiaChi'],
                'phone' => $user['DienThoai'],
                'pos' => $user['MaChucVu'],
            ]
        ]);
    }

    public function store(Request $request)
    {
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
                'DienThoai' => $request['phone'],
                'MaChucVu' => $request['pos'],
                'MaTaiKhoan' => $acc['Id']
            ]
        );

        return redirect('/taikhoan');
    }

    public function update(int $id, Request $request)
    {
        $user = NhanVien::query()->with(['taiKhoan'])->findOrFail($id);

        $acc = User::where('TenDangNhap', $request['username'])->first();
        if ($acc && $acc['Id'] !== $user['MaTaiKhoan']) {
            throw ValidationException::withMessages(['message' => "DUPLICATE_USER"]);
        }

        $user['taiKhoan']->update([
            'TenDangNhap' => $request['username'],
            'QuyenId' => $request['role']
        ]);

        $user->update([
            'HoVaTen' => $request['fullName'],
            'NgaySinh' => $request['dob'],
            'DiaChi' => $request['address'],
            'DienThoai' => $request['phone'],
            'MaChucVu' => $request['pos'],
        ]);

        return redirect('/taikhoan');
    }

    public function destroy(int $id)
    {
        NhanVien::destroy($id);

        return redirect('/taikhoan');
    }
}
