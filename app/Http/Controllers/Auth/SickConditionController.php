<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\News;
use App\Models\Patient;
use App\Models\TinhTrangBenh;
use App\Models\TinTuc;
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

class SickConditionController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Sick/List');
    }

    public function paginate(Request $request)
    {
        $sick = TinhTrangBenh::query()->paginate(10);

        return [
            "sicks" => collect($sick->items())->map(function ($item) {
                return [
                    "name" => $item['Ten'],
                    "desc" => $item['MieuTa'],
                ];
            }),
            "totalPage" => $sick->total(),
        ];
    }
}
