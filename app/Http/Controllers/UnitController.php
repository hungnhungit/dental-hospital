<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DonViTinh;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class UnitController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Unit/List');
    }

    public function paginate(Request $request)
    {
        $units = DonViTinh::paginate(10);

        return [
            "units" => collect($units->items())->map(function ($item) {
                return [
                    "name" => $item['TenDVT'],
                    "desc" => $item['Mota'],
                    "calc" => $item['Hesotinh']
                ];
            }),
            "totalPage" => $units->total(),
        ];
    }
}
