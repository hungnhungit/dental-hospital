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
                    "id" => $item['Id'],
                    "title" => $item['TieuDe'],
                    "desc" => $item['NoiDung'],
                    "kindNew" => $item['loaiTinTuc']['LoaiTinTuc']
                ];
            }),
            "totalPage" => $news->total(),
        ]);
    }

    public function blog(): Response
    {
        $news = TinTuc::with(['loaiTinTuc'])->get();

        return Inertia::render('Blog/List', [
            "news" => collect($news)->map(function ($item) {
                return [
                    "id" => $item['Id'],
                    "title" => $item['TieuDe'],
                    "desc" => $item['NoiDung'],
                    "kindNew" => $item['loaiTinTuc']['LoaiTinTuc']
                ];
            }),
        ]);
    }

    public function create()
    {
        $kindNews = LoaiTinTuc::all();

        return Inertia::render('News/New', [
            'kindNews' => collect($kindNews)->map(function ($item) {
                return [
                    "id" => $item["Id"],
                    "name" => $item['LoaiTinTuc']
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
                    "id" => $item["Id"],
                    "name" => $item['LoaiTinTuc']
                ];
            }),
            "news" => [
                "id" => $new['Id'],
                "name" => $new['TieuDe'],
                "desc" => $new['NoiDung'],
                'kind' => $new['LoaiTinTuc']
            ]
        ]);
    }

    public function update(int $id, Request $request)
    {
        $record = TinTuc::query()->findOrFail($id);
        $currentUser = $request->user();

        $record->update([
            'TieuDe' => $request['name'],
            'NoiDung' => $request['desc'],
            'TacGia' => $currentUser['Id'],
            'LoaiTinTuc' => $request['kind']
        ]);

        return redirect('/tin-tuc');
    }

    public function store(Request $request)
    {
        $currentUser = $request->user();
        TinTuc::create([
            'TieuDe' => $request['name'],
            'NoiDung' => $request['desc'],
            'TacGia' => $currentUser['Id'],
            'LoaiTinTuc' => $request['kind']
        ]);
        return redirect('/tin-tuc');
    }

    public function destroy(int $id)
    {
        TinTuc::destroy($id);

        return back();
    }
}
