<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Admin;
use App\Models\BenhNhan;
use App\Models\ChucVu;
use App\Models\DichVu;
use App\Models\DonViTinh;
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
        SoKhamBenh::truncate();
        LoaiVatTu::truncate();
        LoaiThuoc::truncate();
        DonViTinh::truncate();
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
            "TaiKhoanId" => $admin['idTK']
        ]);

        NhanVien::create([
            'HoVaTen' => 'Nguyễn Thái Hưng',
            "DienThoai" => '0707295002',
            "NgaySinh" => $faker->dateTime(),
            "DiaChi" => "Hải Phòng",
            "ChucVuId" => 1,
            "TaiKhoanId" => $doctor['idTK']
        ]);

        NhanVien::create([
            'HoVaTen' => 'Ngô Bích Ngọc',
            "DienThoai" => '0707295002',
            "NgaySinh" => $faker->dateTime(),
            "DiaChi" => "Hải Phòng",
            "ChucVuId" => 2,
            "TaiKhoanId" => $receptionist['idTK']
        ]);

        NhanVien::create([
            'HoVaTen' => 'Tiểu Vy',
            "DienThoai" => '0707295002',
            "NgaySinh" => $faker->dateTime(),
            "DiaChi" => "Hải Phòng",
            "ChucVuId" => 3,
            "TaiKhoanId" => $nurse['idTK']
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
            'idLoaiDV' => $kindService1['idLDV']
        ]);

        DichVu::create([
            'Ten' => 'Hàm',
            'MieuTa' => 'Hàm',
            'Gia' => 2000,
            'idLoaiDV' => $kindService1['idLDV']
        ]);

        DichVu::create([
            'Ten' => 'Mặt',
            'MieuTa' => 'Mặt',
            'Gia' => 3000,
            'idLoaiDV' => $kindService1['idLDV']
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
            'BenhNhanId' => $patient1['idBN'],
            'ThanhToanId' => 1,
        ]);

        HoaDon::create([
            'MaHoaDon' => $faker->numerify('BILL-####'),
            'TongTien' => 1000000,
            'NguoiTao' => 2,
            'BenhNhanId' => $patient3['idBN'],
            'ThanhToanId' => 2,
        ]);

        HoaDon::create([
            'MaHoaDon' => $faker->numerify('BILL-####'),
            'TongTien' => 3000000,
            'NguoiTao' => 2,
            'BenhNhanId' => $patient2['idBN'],
            'ThanhToanId' => 3,
        ]);

        LichKham::create([
            'NguoiTao' => 3,
            'BacSi' => $doctor['idNV'],
            'ThoiGian' => $faker->dateTime()
        ]);

        LichKham::create([
            'NguoiTao' => 3,
            'BacSi' => $doctor['idNV'],
            'ThoiGian' => $faker->dateTime()
        ]);

        LichKham::create([
            'NguoiTao' => 3,
            'BacSi' => $doctor['idNV'],
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
            'LoaiTinTucId' => $kindNew1['idLTT'],
            'AdminId' => $admin['idTK']
        ]);

        TinTuc::create([
            'TieuDe' => $faker->text(20),
            'MieuTa' => $faker->text(50),
            'LoaiTinTucId' => $kindNew1['idLTT'],
            'AdminId' => $admin['idTK']
        ]);

        TinTuc::create([
            'TieuDe' => $faker->text(20),
            'MieuTa' => $faker->text(50),
            'LoaiTinTucId' => $kindNew1['idLTT'],
            'AdminId' => $admin['idTK']
        ]);

        DonViTinh::create([
            'TenDVT' => 'Cái',
            'Mota' => 'Cái',
            'Hesotinh' => 1
        ]);

        DonViTinh::create([
            'TenDVT' => 'Vỉ',
            'Mota' => 'Vỉ',
            'Hesotinh' => 1
        ]);

        LoaiVatTu::create([
            'TenloaiVT' => 'Máy',
            'MoTa' => 'Máy chiếu',
            'Donvitinh' => 1
        ]);

        LoaiVatTu::create([
            'TenloaiVT' => 'Dụng cụ',
            'MoTa' => 'Dụng cụ',
            'Donvitinh' => 1
        ]);

        LoaiThuoc::create([
            'TenLT' => 'Kháng sinh',
            'Mota' => 'Kháng sinh',
            'idDonvitinh' => 2
        ]);

        LoaiThuoc::create([
            'TenLT' => 'Thuốc tê',
            'Mota' => 'Thuốc tê',
            'idDonvitinh' => 2
        ]);

        // SoKhamBenh::create([
        //     'TieuSu' => 'Răng',
        //     'BenhNhanId' => $patient1['idBN'],
        //     'NguoiKham' => 1,
        //     'idTTDT' => 1
        // ]);

        // SoKhamBenh::create([
        //     'TieuSu' => 'Răng',
        //     'BenhNhanId' => $patient2['idBN'],
        //     'NguoiKham' => 1,
        //     'idTTDT' => 1
        // ]);

        // SoKhamBenh::create([
        //     'TieuSu' => 'Răng',
        //     'BenhNhanId' => $patient3['idBN'],
        //     'NguoiKham' => 1,
        //     'idTTDT' => 1
        // ]);
    }
}
