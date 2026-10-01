<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display registration page.
     */
    public function create(): View
    {
        return view('auth.register');
    }


    /**
     * Handle registration.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                'unique:' . User::class,
            ],

            'password' => [
                'required',
                'confirmed',
                Rules\Password::defaults(),
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | Get Default User Role
        |--------------------------------------------------------------------------
        */

        $userRole = Role::where('name', 'user')
            ->where('status', 1)
            ->first();


        /*
        |--------------------------------------------------------------------------
        | Make Sure User Role Exists
        |--------------------------------------------------------------------------
        */

        if (!$userRole) {

            return back()
                ->withInput()
                ->withErrors([
                    'email' => 'Default user role was not found.',
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Create User
        |--------------------------------------------------------------------------
        */

        $user = User::create([

            'name' => $request->name,

            'email' => $request->email,

            'password' => Hash::make($request->password),

            'role_id' => $userRole->id,

        ]);


        /*
        |--------------------------------------------------------------------------
        | Registered Event
        |--------------------------------------------------------------------------
        */

        event(new Registered($user));


        /*
        |--------------------------------------------------------------------------
        | Login User
        |--------------------------------------------------------------------------
        */

        Auth::login($user);


        /*
        |--------------------------------------------------------------------------
        | Redirect
        |--------------------------------------------------------------------------
        */

        return redirect()->route('home');
    }
}