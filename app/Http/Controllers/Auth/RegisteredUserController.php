<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
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
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'type' => ['required, in:admin,user'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'type' => $request->type,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        $user_type = Auth::user()->type;

        // Check the user type and redirect accordingly
        if ($user_type === 'admin') {

            notyf()->success('Welcome To Admin Dashboard');

            return redirect()->route('admin.dashboard');  // Redirect to admin dashboard

        } elseif ($user_type === 'user') {

            // return 'vdfvds';
            notyf()->success('Welcome To User Dashboard');

            return redirect()->route('user.dashboard');  // Redirect to instructor dashboard
        } elseif ($user_type === 'customer') {

            // return 'vdfvds';
            notyf()->success('Welcome To Customer Dashboard');

            return redirect()->route('customer.dashboard');  // Redirect to instructor dashboard
        }else {
            return redirect()->route('home');  // Redirect to a default route if no match
        }
    }
}
