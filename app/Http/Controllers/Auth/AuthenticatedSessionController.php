<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Providers\RouteServiceProvider;

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
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);
    
        // أضف شرط أن الحالة "مفعل"
        $credentials = $request->only('email', 'password');
        $credentials['status'] = 'مفعل';
    
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
    
            return redirect()->intended(RouteServiceProvider::HOME);
        }
    
        return back()->withErrors([
            'email' => 'بيانات الدخول غير صحيحة أو الحساب غير مفعل.',
        ]);
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
