<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\DichVu;
use App\Models\Patient;
use App\Models\Service;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;
use Role;

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
