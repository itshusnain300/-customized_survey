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
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user_type = Auth::user()->type;

        // Check the user type and redirect accordingly
        if ($user_type === 'admin') {

            notyf()->success('Welcome To Admin Dashboard');

            return redirect()->route('admin.dashboard');  // Redirect to admin dashboard

        } elseif ($user_type === 'user') {

            notyf()->success('Welcome To Admin Dashboard');

            return redirect()->route('user.dashboard');  // Redirect to instructor dashboard
        } elseif ($user_type === 'customer') {

            // return 'vdfvds';
            notyf()->success('Welcome To Customer Dashboard');

            return redirect()->route('customer.dashboard');  // Redirect to instructor dashboard
        }else {

            return redirect()->route('home');  // Redirect to a default route if no match
        }
        // $this->redirectToDashboard();
        // return redirect()->intended(route('dashboard', absolute: false));
    }


    public function redirectToDashboard(): RedirectResponse
    {
        // Get the authenticated user's type
        $user_type = Auth::user()->type;

        // Check the user type and redirect accordingly
        if ($user_type === 'admin') {

            notyf()->success('Welcome To Admin Dashboard');

            return redirect()->route('admin.dashboard');  // Redirect to admin dashboard

        } elseif ($user_type === 'user') {

            notyf()->success('Welcome To Admin Dashboard');

            return redirect()->route('user.dashboard');  // Redirect to instructor dashboard
        }else {

            return redirect()->route('home');  // Redirect to a default route if no match
        }
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
