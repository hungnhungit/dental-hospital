<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Admin;
use App\Models\BenhNhan;
use App\Models\ChucVu;
use App\Models\DichVu;
use App\Models\DonViTinh;
use App\Models\Ham;
use App\Models\HoaDon;
use App\Models\LichKham;
use App\Models\LoaiDichVu;
use App\Models\LoaiThuoc;
use App\Models\LoaiTinTuc;
use App\Models\LoaiVatTu;
use App\Models\NhanVien;
use App\Models\PhanQuyen;
use App\Models\SoKhamBenh;
use App\Models\ThanhToan;
use App\Models\Thuoc;
use App\Models\TienTrinhDieuTri;
use App\Models\TinhTrangBenh;
use App\Models\TinTuc;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\VatTu;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Faker\Factory;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        DB::statement("SET foreign_key_checks=0");
        HoaDon::truncate();
        PhanQuyen::truncate();
        User::truncate();
        NhanVien::truncate();
        ChucVu::truncate();
        BenhNhan::truncate();
        LoaiDichVu::truncate();
        VatTu::truncate();
        Thuoc::truncate();
        DichVu::truncate();
        SoKhamBenh::truncate();
        TinTuc::truncate();
        LoaiTinTuc::truncate();
        TienTrinhDieuTri::truncate();
        LoaiVatTu::truncate();
        LoaiThuoc::truncate();
        DonViTinh::truncate();
        Ham::truncate();
        DB::table('phanquyenham')->truncate();
        DB::table('chitiethoadon')->truncate();
        DB::statement("SET foreign_key_checks=1");

        ChucVu::create([
            'ChucVu' => 'Bác Sĩ',
        ]);

        ChucVu::create([
            'ChucVu' => 'Y Tá',
        ]);

        ChucVu::create([
            'ChucVu' => 'Lễ tân',
        ]);

        PhanQuyen::create([
            'Quyen' => 'admin',
        ]);

        PhanQuyen::create([
            'Quyen' => 'doctor',
        ]);

        PhanQuyen::create([
            'Quyen' => 'nurse',
        ]);

        PhanQuyen::create([
            'Quyen' => 'receptionist',
        ]);

        //users
        $admin = User::create([
            'TenDangNhap' => 'admin',
            'MatKhau' => Hash::make('admin'),
            'QuyenId' => 1,
        ]);

        $doctor = User::create([
            'TenDangNhap' => 'doctor',
            'MatKhau' => Hash::make('doctor'),
            'QuyenId' => 2,
        ]);

        $nurse = User::create([
            'TenDangNhap' => 'nurse',
            'MatKhau' => Hash::make('nurse'),
            'QuyenId' => 3,
        ]);

        $receptionist = User::create([
            'TenDangNhap' => 'receptionist',
            'MatKhau' => Hash::make('receptionist'),
            'QuyenId' => 4,
        ]);

        NhanVien::create([
            'HoVaTen' => 'Nguyễn Thái Hưng',
            "NgaySinh" => $faker->dateTime(),
            "DiaChi" => "Hải Phòng",
            "MaChucVu" => 1,
            "MaTaiKhoan" => $doctor['Id'],
            "DienThoai" => $faker->phoneNumber()
        ]);

        NhanVien::create([
            'HoVaTen' => 'Ngô Bích Ngọc',
            "NgaySinh" => $faker->dateTime(),
            "DiaChi" => "Hải Phòng",
            "MaChucVu" => 2,
            "MaTaiKhoan" => $receptionist['Id'],
            "DienThoai" => $faker->phoneNumber()
        ]);

        NhanVien::create([
            'HoVaTen' => 'Tiểu Vy',
            "NgaySinh" => $faker->dateTime(),
            "DiaChi" => "Hải Phòng",
            "MaChucVu" => 3,
            "MaTaiKhoan" => $nurse['Id'],
            "DienThoai" => $faker->phoneNumber()
        ]);

        BenhNhan::create([
            'HoVaTen' => 'Nguyên Văn A',
            'DiaChi' => $faker->address(),
            "NgaySinh" => $faker->dateTime(),
            'CMND' => $faker->ean8(),
            'CanNang' => 80,
            'ChieuCao' => 150,
            'NhomMau' => 'B'
        ]);
        BenhNhan::create([
            'HoVaTen' => 'Nguyên Văn B',
            'DiaChi' => $faker->address(),
            "NgaySinh" => $faker->dateTime(),
            'CMND' => $faker->ean8(),
            'CanNang' => 80,
            'ChieuCao' => 150,
            'NhomMau' => 'B'
        ]);
        BenhNhan::create([
            'HoVaTen' => 'Nguyên Văn C',
            'DiaChi' => $faker->address(),
            "NgaySinh" => $faker->dateTime(),
            'CMND' => $faker->ean8(),
            'CanNang' => 80,
            'ChieuCao' => 150,
            'NhomMau' => 'O'
        ]);

        $kindService1 = LoaiDichVu::create([
            'LoaiDichVu' => 'Răng',
        ]);

        $kindService2 = LoaiDichVu::create([
            'LoaiDichVu' => 'Hàm',
        ]);

        $kindService3 = LoaiDichVu::create([
            'LoaiDichVu' => 'Mặt',
        ]);

        DichVu::create([
            'TenDichVu' => 'Răng',
            'MoTa' => 'Răng',
            'Gia' => 1000,
            'LoaiDichVuID' => $kindService1['Id']
        ]);

        DichVu::create([
            'TenDichVu' => 'Hàm',
            'MoTa' => 'Hàm',
            'Gia' => 2000,
            'LoaiDichVuID' => $kindService1['Id']
        ]);

        DichVu::create([
            'TenDichVu' => 'Mặt',
            'MoTa' => 'Mặt',
            'Gia' => 3000,
            'LoaiDichVuID' => $kindService1['Id']
        ]);




        $kindNew1 = LoaiTinTuc::create([
            'LoaiTinTuc' => $faker->text(10),
        ]);

        LoaiTinTuc::create([
            'LoaiTinTuc' => $faker->text(10),
        ]);

        TinTuc::create([
            'TieuDe' => $faker->text(20),
            'NoiDung' => $faker->text(50),
            'LoaiTinTuc' => $kindNew1['Id'],
            'TacGia' => $admin['Id']
        ]);

        TinTuc::create([
            'TieuDe' => $faker->text(20),
            'NoiDung' => $faker->text(50),
            'LoaiTinTuc' => $kindNew1['Id'],
            'TacGia' => $admin['Id']
        ]);

        TinTuc::create([
            'TieuDe' => $faker->text(20),
            'NoiDung' => $faker->text(50),
            'LoaiTinTuc' => $kindNew1['Id'],
            'TacGia' => $admin['Id']
        ]);

        DonViTinh::create([
            'DonVi' => 'Cái',
            'HeSo' => 1
        ]);

        DonViTinh::create([
            'DonVi' => 'Vỉ',
            'HeSo' => 1
        ]);

        LoaiVatTu::create([
            'LoaiVatTu' => 'Máy',
        ]);

        LoaiVatTu::create([
            'LoaiVatTu' => 'Dụng cụ',
        ]);

        LoaiThuoc::create([
            'LoaiThuoc' => 'Kháng sinh',
        ]);

        LoaiThuoc::create([
            'LoaiThuoc' => 'Thuốc tê',
        ]);

        Thuoc::create([
            'TenThuoc' => 'Kháng sinh',
            'LoaiThuocId' => 1,
            'MaDonVi' => 1,
            'CongDung' => 'Chữa bệnh',
            'CachDung' => 'Uống',
            'SoLuong' => 10,
            'HSD' => $faker->dateTime()
        ]);

        Thuoc::create([
            'TenThuoc' => 'Lipitor',
            'LoaiThuocId' => 1,
            'MaDonVi' => 1,
            'CongDung' => 'Chữa bệnh',
            'CachDung' => 'Uống',
            'SoLuong' => 0,
            'HSD' => $faker->dateTime()
        ]);

        Thuoc::create([
            'TenThuoc' => 'Nhỏ mũi',
            'LoaiThuocId' => 1,
            'MaDonVi' => 1,
            'CongDung' => 'Chữa bệnh',
            'CachDung' => 'Uống',
            'SoLuong' => 10,
            'HSD' => $faker->dateTime()
        ]);

        Thuoc::create([
            'TenThuoc' => 'Kháng viêm',
            'LoaiThuocId' => 1,
            'MaDonVi' => 1,
            'CongDung' => 'Chữa bệnh',
            'CachDung' => 'Uống',
            'SoLuong' => 100,
            'HSD' => $faker->dateTime()
        ]);

        VatTu::create([
            'TenVT' => 'Máy soi',
            'LoaiVatTuID' => 1,
            'MaDonVi' => 1,
            'SoLuong' => 1
        ]);

        VatTu::create([
            'TenVT' => 'Máy chiếu',
            'LoaiVatTuID' => 1,
            'MaDonVi' => 1,
            'SoLuong' => 20
        ]);

        VatTu::create([
            'TenVT' => 'X-Quang',
            'LoaiVatTuID' => 1,
            'MaDonVi' => 1,
            'SoLuong' => 0
        ]);

        SoKhamBenh::create([
            'MaBenhNhan' => 1,
            'MaBacSi' => 1,
            'ChanDoanBenh' => 'Đau răng'
        ]);

        SoKhamBenh::create([
            'MaBenhNhan' => 2,
            'MaBacSi' => 1,
            'ChanDoanBenh' => 'Đau răng'
        ]);

        TienTrinhDieuTri::create([
            'TenTienTrinh' => $faker->numerify('TTDT-####'),
            'MaSoKhamBenh' => 1,
            'MaThuoc' => 1,
            'SoThuoc' => 1,
            'NgayDieuTri' => now()->format('Y-m-d'),
            'ChiTietDieuTri' => 'Điều trị',
            'MaVatTu' => 1,
            'SoVatTu' => 1,
        ]);
        TienTrinhDieuTri::create([
            'TenTienTrinh' => $faker->numerify('TTDT-####'),
            'MaSoKhamBenh' => 2,
            'MaThuoc' => 1,
            'SoThuoc' => 1,
            'NgayDieuTri' => now()->format('Y-m-d'),
            'ChiTietDieuTri' => 'Điều trị',
            'MaVatTu' => 1,
            'SoVatTu' => 1,
        ]);

        $permissions = ['thuoc', 'vat-tu', 'hoadon', 'loai-thuoc', 'loai-vat-tu', 'sokhambenh', 'benhnhan', 'dichvu', 'loai-dich-vu', 'donvitinh', 'tientrinhdieutri'];

        foreach ($permissions as $permission) {
            foreach (['index', 'store', 'update', 'destroy'] as $action) {
                Ham::create([
                    'TenHam' => $permission . '.' . $action
                ]);
            }
        }

        $roles = PhanQuyen::query()->where('Quyen', '!=', 'admin')->get();
        $hams = Ham::query()->get();

        foreach ($roles as $role) {
            $insert = [];
            foreach ($hams as $key => $ham) {
                array_push($insert, [
                    "PhanQuyenId" => $role['Id'],
                    "HamId" => $ham['Id'],
                    "on" => true
                ]);
            }
            DB::table('phanquyenham')->insert($insert);
        }
    }
}
