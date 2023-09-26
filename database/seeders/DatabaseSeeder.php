<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Admin;
use App\Models\BenhNhan;
use App\Models\ChucVu;
use App\Models\DichVu;
use App\Models\HoaDon;
use App\Models\LichKham;
use App\Models\LoaiDichVu;
use App\Models\LoaiTinTuc;
use App\Models\NhanVien;
use App\Models\PhanQuyen;
use App\Models\SoKhamBenh;
use App\Models\ThanhToan;
use App\Models\TinhTrangBenh;
use App\Models\TinTuc;
use Illuminate\Database\Seeder;
use App\Models\User;
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
        Admin::truncate();
        BenhNhan::truncate();
        LichKham::truncate();
        LoaiDichVu::truncate();
        DichVu::truncate();
        ThanhToan::truncate();
        TinhTrangBenh::truncate();
        SoKhamBenh::truncate();
        DB::statement("SET foreign_key_checks=1");

        ChucVu::create([
            'TenChucVu' => 'Bác Sĩ',
            'MoTa' => 'Bác Sĩ'
        ]);

        ChucVu::create([
            'TenChucVu' => 'Y Tá',
            'MoTa' => 'Y Tá'
        ]);

        ChucVu::create([
            'TenChucVu' => 'Lễ tân',
            'MoTa' => 'Lễ tân'
        ]);

        PhanQuyen::create([
            'Ten' => 'admin',
            'Mota' => 'admin'
        ]);

        PhanQuyen::create([
            'Ten' => 'doctor',
            'Mota' => 'doctor'
        ]);

        PhanQuyen::create([
            'Ten' => 'nurse',
            'Mota' => 'nurse'
        ]);

        PhanQuyen::create([
            'Ten' => 'receptionist',
            'Mota' => 'receptionist'
        ]);

        //users
        $admin = User::create([
            'TenTaiKhoan' => 'admin',
            'MatKhau' => Hash::make('admin'),
            'PhanQuyenId' => 1,
            'MoTa' => 'Admin',
        ]);

        $doctor = User::create([
            'TenTaiKhoan' => 'doctor',
            'MatKhau' => Hash::make('doctor'),
            'PhanQuyenId' => 2,
            'MoTa' => 'Doctor',
        ]);

        $nurse = User::create([
            'TenTaiKhoan' => 'nurse',
            'MatKhau' => Hash::make('nurse'),
            'PhanQuyenId' => 3,
            'MoTa' => 'Nurse',
        ]);

        $receptionist = User::create([
            'TenTaiKhoan' => 'receptionist',
            'MatKhau' => Hash::make('receptionist'),
            'PhanQuyenId' => 4,
            'MoTa' => 'receptionist',
        ]);

        Admin::create([
            'HoVaTen' => 'Quản trị viên',
            "DienThoai" => '0707295002',
            "DiaChi" => "Hải Phòng",
            "TaiKhoanId" => $admin['id']
        ]);

        NhanVien::create([
            'HoVaTen' => 'Nguyễn Thái Hưng',
            "DienThoai" => '0707295002',
            "NgaySinh" => $faker->dateTime(),
            "DiaChi" => "Hải Phòng",
            "ChucVuId" => 1,
            "TaiKhoanId" => $doctor['id']
        ]);

        NhanVien::create([
            'HoVaTen' => 'Ngô Bích Ngọc',
            "DienThoai" => '0707295002',
            "NgaySinh" => $faker->dateTime(),
            "DiaChi" => "Hải Phòng",
            "ChucVuId" => 2,
            "TaiKhoanId" => $receptionist['id']
        ]);

        NhanVien::create([
            'HoVaTen' => 'Tiểu Vy',
            "DienThoai" => '0707295002',
            "NgaySinh" => $faker->dateTime(),
            "DiaChi" => "Hải Phòng",
            "ChucVuId" => 3,
            "TaiKhoanId" => $nurse['id']
        ]);

        $patient1 = BenhNhan::create([
            'HoVaTen' => 'Nguyên Văn A',
            'DiaChi' => $faker->address(),
            "DienThoai" => $faker->randomNumber(9, true),
            "NgaySinh" => $faker->dateTime(),
            'cccd' => $faker->ean8()
        ]);

        $patient2 = BenhNhan::create([
            'HoVaTen' => 'Nguyên Văn B',
            'DiaChi' => $faker->address(),
            "DienThoai" => $faker->randomNumber(9, true),
            "NgaySinh" => $faker->dateTime(),
            'cccd' => $faker->ean8()
        ]);

        $patient3 = BenhNhan::create([
            'HoVaTen' => 'Nguyên Văn C',
            'DiaChi' => $faker->address(),
            "DienThoai" => $faker->randomNumber(9, true),
            "NgaySinh" => $faker->dateTime(),
            'cccd' => $faker->ean8()
        ]);

        TinhTrangBenh::create([
            'Ten' => 'Đau răng',
            'MieuTa' => 'Đau răng',
        ]);

        TinhTrangBenh::create([
            'Ten' => 'Đau lợi',
            'MieuTa' => 'Đau lợi',
        ]);

        $kindService1 = LoaiDichVu::create([
            'Ten' => 'Răng',
            'MieuTa' => 'Răng',
        ]);

        $kindService2 = LoaiDichVu::create([
            'Ten' => 'Hàm',
            'MieuTa' => 'Hàm',
        ]);

        $kindService3 = LoaiDichVu::create([
            'Ten' => 'Mặt',
            'MieuTa' => 'Mặt',
        ]);

        DichVu::create([
            'Ten' => 'Răng',
            'MieuTa' => 'Răng',
            'Gia' => 1000,
            'LoaiDichVuId' => $kindService1->id
        ]);

        DichVu::create([
            'Ten' => 'Hàm',
            'MieuTa' => 'Hàm',
            'Gia' => 2000,
            'LoaiDichVuId' => $kindService2->id
        ]);

        DichVu::create([
            'Ten' => 'Mặt',
            'MieuTa' => 'Mặt',
            'Gia' => 3000,
            'LoaiDichVuId' => $kindService3->id
        ]);

        ThanhToan::create([
            'TenHinhThucThanhToan' => 'CK',
            'TrangThai' => 'DangXuLy'
        ]);

        ThanhToan::create([
            'TenHinhThucThanhToan' => 'TM',
            'TrangThai' => 'ThanhCong'
        ]);

        ThanhToan::create([
            'TenHinhThucThanhToan' => 'CK',
            'TrangThai' => 'HuyBo'
        ]);

        HoaDon::create([
            'MaHoaDon' => $faker->numerify('BILL-####'),
            'TongTien' => 1000000,
            'NguoiTao' => 2,
            'BenhNhanId' => $patient1->id,
            'ThanhToanId' => 1,
        ]);

        HoaDon::create([
            'MaHoaDon' => $faker->numerify('BILL-####'),
            'TongTien' => 1000000,
            'NguoiTao' => 2,
            'BenhNhanId' => $patient3->id,
            'ThanhToanId' => 2,
        ]);

        HoaDon::create([
            'MaHoaDon' => $faker->numerify('BILL-####'),
            'TongTien' => 3000000,
            'NguoiTao' => 2,
            'BenhNhanId' => $patient2->id,
            'ThanhToanId' => 3,
        ]);

        LichKham::create([
            'NguoiTao' => 3,
            'BacSi' => $doctor->id,
            'ThoiGian' => $faker->dateTime()
        ]);

        LichKham::create([
            'NguoiTao' => 3,
            'BacSi' => $doctor->id,
            'ThoiGian' => $faker->dateTime()
        ]);

        LichKham::create([
            'NguoiTao' => 3,
            'BacSi' => $doctor->id,
            'ThoiGian' => $faker->dateTime()
        ]);

        $kindNew1 = LoaiTinTuc::create([
            'Ten' => $faker->text(10),
            'DuongDan' => $faker->slug()
        ]);

        LoaiTinTuc::create([
            'Ten' => $faker->text(10),
            'DuongDan' => $faker->slug()
        ]);

        TinTuc::create([
            'TieuDe' => $faker->text(20),
            'MieuTa' => $faker->text(50),
            'LoaiTinTucId' => $kindNew1->id,
            'AdminId' => $admin->id
        ]);

        TinTuc::create([
            'TieuDe' => $faker->text(20),
            'MieuTa' => $faker->text(50),
            'LoaiTinTucId' => $kindNew1->id,
            'AdminId' => $admin->id
        ]);

        TinTuc::create([
            'TieuDe' => $faker->text(20),
            'MieuTa' => $faker->text(50),
            'LoaiTinTucId' => $kindNew1->id,
            'AdminId' => $admin->id
        ]);

        SoKhamBenh::create([
            'TieuSu' => 'Răng',
            'BenhNhanId' => $patient1['id'],
            'NguoiTao' => 3,
            'NguoiKham' => 1,
            'TinhTrangBenhId' => 1
        ]);

        SoKhamBenh::create([
            'TieuSu' => 'Răng',
            'BenhNhanId' => $patient2['id'],
            'NguoiTao' => 3,
            'NguoiKham' => 1,
            'TinhTrangBenhId' => 1
        ]);

        SoKhamBenh::create([
            'TieuSu' => 'Răng',
            'BenhNhanId' => $patient3['id'],
            'NguoiTao' => 3,
            'NguoiKham' => 1,
            'TinhTrangBenhId' => 1
        ]);
    }
}
