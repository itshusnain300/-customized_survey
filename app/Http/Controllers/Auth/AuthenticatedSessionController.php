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
        
        $user = Auth::user();
    
        switch ($user->type) {
            case 'admin':
                notyf()->success('Welcome To Admin Dashboard');
                return redirect()->route('admin.dashboard');
    
            case 'user':
                notyf()->success('Welcome To User Dashboard');
                return redirect()->route('user.dashboard');
    
            case 'customer':
                notyf()->success('Welcome To Customer Dashboard');
                return redirect()->route('customer.dashboard');
    
            default:
                return back();  
        }
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
