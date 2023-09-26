<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\LoaiDichVu;
use Inertia\Inertia;
use Inertia\Response;

class KindServicesController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('KindServices/List');
    }

    public function paginate()
    {
        $kindService = LoaiDichVu::paginate(10);

        return [
            "kindServices" => collect($kindService->items())->map(function ($item) {
                return [
                    "name" => $item['Ten'],
                    "desc" => $item['MieuTa'],
                ];
            }),
            "totalPage" => $kindService->total(),
        ];
    }
}
