<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\KindNew;
use App\Models\LoaiTinTuc;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class KindNewController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('KindNew/List');
    }

    public function paginate(Request $request)
    {
        $kindNew = LoaiTinTuc::paginate(10);

        return [
            "kindNew" => collect($kindNew->items())->map(function ($item) {
                return [
                    "name" => $item['Ten'],
                    "slug" => $item['DuongDan']
                ];
            }),
            "totalPage" => $kindNew->total(),
        ];
    }
}
