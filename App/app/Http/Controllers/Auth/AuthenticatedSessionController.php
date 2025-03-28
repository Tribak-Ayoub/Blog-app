<?php

// namespace App\Http\Controllers\Auth;

// use App\Http\Controllers\Controller;
// use App\Http\Requests\Auth\LoginRequest;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
// use Laravel\Sanctum\HasApiTokens;
// use App\Models\User;

// class AuthenticatedSessionController extends Controller
// {
//     /**
//      * Display the login view.
//      */
//     public function create()
//     {
//         return view('auth.login');
//     }

//     /**
//      * Handle an incoming authentication request.
//      */
//     public function store(LoginRequest $request)
//     {
//         $request->authenticate();
//         $request->session()->regenerate();

//         $user = Auth::user();

//         // Revoke previous tokens and create a new one
//         $user->tokens()->delete();
//         $token = $user->createToken('auth_token')->plainTextToken;

//         return response()->json([
//             'token' => $token,
//         ]);
//     }

//     /**
//      * Destroy an authenticated session.
//      */
//     public function destroy(Request $request)
//     {
//         $user = Auth::user();
//         if ($user) {
//             $user->tokens()->delete(); // Revoke all tokens
//         }

//         Auth::guard('web')->logout();

//         $request->session()->invalidate();
//         $request->session()->regenerateToken();

//         return response()->json(['message' => 'Logged out successfully']);
//     }
// }




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
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended('/');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/home');
    }
}
