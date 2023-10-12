<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DichVu;
use Inertia\Inertia;
use Inertia\Response;

class ServiceController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Services/List');
    }

    public function paginate()
    {
        $services = DichVu::with('loaiDichVu')->paginate(10);

        return [
            "services" => collect($services->items())->map(function ($item) {
                return [
                    "name" => $item['Ten'],
                    "desc" => $item['MieuTa'],
                    "price" => $item['Gia'],
                    'kindService' => $item['loaiDichVu']['Ten']
                ];
            }),
            "totalPage" => $services->total(),
        ];
    }
}
