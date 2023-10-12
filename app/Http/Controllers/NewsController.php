<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\LoaiTinTuc;
use App\Models\TinTuc;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class NewsController extends Controller
{
    public function index(): Response
    {
        $news = TinTuc::with(['loaiTinTuc'])->paginate(10);

        return Inertia::render('News/List', [
            "news" => collect($news->items())->map(function ($item) {
                return [
                    "id" => $item['idTinTuc'],
                    "title" => $item['TieuDe'],
                    "desc" => $item['MieuTa'],
                    "kindNew" => $item['loaiTinTuc']['Ten']
                ];
            }),
            "totalPage" => $news->total(),
        ]);
    }

    public function new()
    {
        $kindNews = LoaiTinTuc::all();

        return Inertia::render('News/New', [
            'kindNews' => collect($kindNews)->map(function ($item) {
                return [
                    "id" => $item["idLTT"],
                    "name" => $item['Ten']
                ];
            })
        ]);
    }

    public function edit(int $id)
    {
        $kindNews = LoaiTinTuc::all();
        $new = TinTuc::query()->findOrFail($id);

        return Inertia::render('News/New', [
            'kindNews' => collect($kindNews)->map(function ($item) {
                return [
                    "id" => $item["idLTT"],
                    "name" => $item['Ten']
                ];
            }),
            "news" => [
                "id" => $new['idTinTuc'],
                "name" => $new['TieuDe'],
                "desc" => $new['MieuTa'],
                'kind' => $new['LoaiTinTucId']
            ]
        ]);
    }

    public function update(int $id, Request $request)
    {
        $record = TinTuc::query()->findOrFail($id);

        $record->update([
            'TieuDe' => $request['name'],
            'MieuTa' => $request['desc'],
            'LoaiTinTucId' => $request['kind']
        ]);

        return redirect('/tin-tuc');
    }

    public function store(Request $request)
    {
        $currentUser = $request->user();
        TinTuc::create([
            'TieuDe' => $request['name'],
            'MieuTa' => $request['desc'],
            'AdminId' => $currentUser['idTK'],
            'LoaiTinTucId' => $request['kind']
        ]);
        return redirect('/tin-tuc');
    }

    public function destroy(Request $request)
    {
        TinTuc::destroy($request['id']);

        return redirect('/tin-tuc');
    }
}
