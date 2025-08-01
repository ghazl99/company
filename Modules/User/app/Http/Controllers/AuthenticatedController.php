<?php

namespace Modules\User\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\User\Http\Requests\LoginRequest;
use Modules\User\Services\UserService;

class AuthenticatedController extends Controller
{
    public function __construct(
        protected UserService $userService,
    ) {}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user::auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    {
        DB::beginTransaction();
        $request->authenticate();
        $user = Auth::user();
        $request->session()->regenerate();
        $this->userService->logLogin($user);
        DB::commit();

        return redirect()->route('dashboard');

    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
