<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\ExaminationSchedule;
use App\Models\LichKham;
use App\Models\Patient;
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

class ExaminationScheduleController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('ExaminationSchedule/List');
    }

    public function register(): Response
    {
        return Inertia::render('RegisterExaminationSchedule/Register');
    }

    public function paginate(Request $request)
    {
        $examinationSchedule = LichKham::with(['bacSi', 'nguoiTao'])->paginate(10);

        return [
            "examinationSchedule" => collect($examinationSchedule->items())->map(function ($item) {
                return [
                    "doctor" => $item['bacSi']['HoVaTen'],
                    "created_by" => $item['nguoiTao']['HoVaTen'],
                    "registration_date" => $item['ThoiGian'],
                ];
            }),
            "totalPage" => $examinationSchedule->total(),
        ];
    }
}
