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

        // Regenerate session after successful login
        $request->session()->regenerate();

        // Get logged-in user
        $user = Auth::user();

        // Make sure role exists
        if (!$user || !$user->role) {
            Auth::logout();

            return redirect()
                ->route('login')
                ->withErrors([
                    'email' => 'User role is not configured.',
                ]);
        }

        $role = strtolower($user->role->name);

        // Admin / Super Admin
        if (in_array($role, ['admin', 'super-admin'])) {
            return redirect()->route('dashboard');
        }

        // Staff
        if ($role === 'staff') {
            return redirect()->route('sms.index');
        }

        // Auditor
        if ($role === 'auditor') {
            return redirect()->route('sms.report');
        }

        // Unknown role
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