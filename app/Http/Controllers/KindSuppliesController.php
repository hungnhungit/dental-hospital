<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\LoaiVatTu;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class KindSuppliesController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('KindSupplies/List');
    }

    public function paginate(Request $request)
    {
        $supplies = LoaiVatTu::paginate(10);

        return [
            "supplies" => collect($supplies->items())->map(function ($item) {
                return [
                    "name" => $item['TenloaiVT'],
                    "desc" => $item['MoTa'],
                ];
            }),
            "totalPage" => $supplies->total(),
        ];
    }
}
