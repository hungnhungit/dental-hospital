<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\HoaDon;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Str;

class UploadController extends Controller
{
    public function upload(Request $request)
    {
        if (!$request->hasFile('file')) {
            // Nếu không thì in ra thông báo
            return "Mời chọn file cần upload";
        }
        $image = $request->file('file');
        $fileName = Str::random(40) . '.' . $image->extension();
        $image->move('storage', $fileName);
        return [
            'fileName' => $fileName,
            'link' => asset('storage/' . $fileName)
        ];
    }
}
