<?php

namespace App\Http\Middleware;

use App\Models\Admin;
use App\Models\NhanVien;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $user = null;

        if ($request->user()) {
            $currentUser = User::query()->with('role')->where('id', $request->user()['id'])->first();
            if ($currentUser->role['Ten'] === 'admin') {
                $admin = Admin::query()->where('TaiKhoanId', $currentUser['id'])->first();
                $user['role'] =  $currentUser->role['Ten'];
                $user['full_name'] = $admin['HoVaTen'];
            } else {
                $employee = NhanVien::query()->where('TaiKhoanId', $currentUser['id'])->first();
                $user['role'] =  $currentUser->role['Ten'];
                $user['full_name'] = $employee['HoVaTen'];
            }
        }

        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $user
            ],
            'ziggy' => function () use ($request) {
                return array_merge((new Ziggy)->toArray(), [
                    'location' => $request->url(),
                ]);
            },
        ]);
    }
}
