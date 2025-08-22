<?php

namespace App\Http\Middleware;

use App\Models\Client;
use App\Models\Company;
use Illuminate\Http\Request;
use Inertia\Middleware;

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
        $user = $request->user();
        $userCompanies = $user?->client?->company;       
        return [
            ...parent::share($request),
            'auth' => [
                'user' => $user,
                'userCompanies' => $userCompanies,
                'is_admin' => $user ? $user->hasRole('SuperAdmin') : false,
                'is_owner' => $user ? $user->hasRole('dueño') : false,
                'is_worker' => $user ? $user->hasRole('Worker') : false,
            ],
            'flash' => [
                'message' => session('title')? true: false,
                'title' => session('title'),
                'type' => session('type'),
                'content' => session('message')
            ]
        ];
    }

        
}
