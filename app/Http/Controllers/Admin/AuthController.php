<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AuthController extends Controller
{
    // GET /admin/login
    public function create(): View
    {
        return view('admin.auth.login');
    }

    // POST /admin/login — only users holding at least one role may enter the admin
    public function store(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            throw ValidationException::withMessages(['email' => 'These credentials do not match our records.']);
        }

        if ($request->user()->roles()->doesntExist()) {
            Auth::logout();

            throw ValidationException::withMessages(['email' => 'Your account does not have admin access.']);
        }

        $request->session()->regenerate();

        return redirect()->intended(route('admin.dashboard'));
    }

    // POST /admin/logout
    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
