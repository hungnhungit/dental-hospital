<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\News;
use App\Models\Patient;
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

class NewsController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('News/List');
    }

    public function paginate(Request $request)
    {
        $news = TinTuc::with(['loaiTinTuc'])->paginate(10);

        return [
            "news" => collect($news->items())->map(function ($item) {
                return [
                    "title" => $item['TieuDe'],
                    "desc" => $item['MieuTa'],
                    "kindNew" => $item['loaiTinTuc']['Ten']
                ];
            }),
            "totalPage" => $news->total(),
        ];
    }
}
