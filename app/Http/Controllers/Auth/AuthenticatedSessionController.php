<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display login page.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle login.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Authenticate user
        $request->authenticate();

        // Regenerate session
        $request->session()->regenerate();

        // Get logged-in user
        $user = Auth::user();

        // Check user and role
        if (!$user || !$user->role) {

            Auth::logout();

            return redirect()
                ->route('login')
                ->withErrors([
                    'email' => 'Your account does not have a valid role.',
                ]);
        }

        // Get role name
        $role = strtolower(trim($user->role->name));

        /*
        |--------------------------------------------------------------------------
        | Admin
        |--------------------------------------------------------------------------
        */
        if ($role === 'admin') {
            return redirect()->route('dashboard');
        }

        /*
        |--------------------------------------------------------------------------
        | Super Admin
        |--------------------------------------------------------------------------
        */
        if ($role === 'super-admin') {
            return redirect()->route('dashboard');
        }

        /*
        |--------------------------------------------------------------------------
        | Normal User
        |--------------------------------------------------------------------------
        */
        if ($role === 'user') {
            return redirect()->route('home');
        }

        /*
        |--------------------------------------------------------------------------
        | Unknown Role
        |--------------------------------------------------------------------------
        */

        Auth::logout();

        return redirect()
            ->route('login')
            ->withErrors([
                'email' => 'Your account does not have a valid role.',
            ]);
    }

    /**
     * Logout.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}