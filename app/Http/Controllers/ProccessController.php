<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BenhNhan;
use App\Models\NhanVien;
use App\Models\SoKhamBenh;
use App\Models\TienTrinhDieuTri;
use App\Models\TinhTrangBenh;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ProccessController extends Controller
{
    public function create(int $id)
    {
        TienTrinhDieuTri::destroy($id);

        return Inertia::render('Proccess/New', []);
    }

    public function destroy(int $id)
    {
        TienTrinhDieuTri::destroy($id);

        return back();
    }
}
