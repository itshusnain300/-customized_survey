<?php

namespace App\Http\Controllers\Admin;

// use App\Http\Controllers\Admin\Controller;

use App\Http\Requests\UserStoreRequest;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(10);
    
        return view('admin.user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.user.create');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(UserStoreRequest $request)
    {
        $validatedData = $request->validated();

        try {
            $user = User::create($validatedData);

            // $admin->notyf(new NewadminJobRequestRecevied($admin));

            notyf()->success('New user successfully created.');
            return back();

        } catch (\Throwable $th) {
            throw $th;
            notyf()->error('Failed to create admin. Please try again.SCDS');
        }

        // event(new Registered($admin));
        
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        // return $user->submittedVendors->map->vendor;
        return view('admin.user.show', compact('user', )); // Pass both variables correctly
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $companies = Company::latest()->get();
        return view('admin.user.update', compact('user', 'companies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserStoreRequest $request, User $user)
    {
        $validatedData = $request->validated();  

        try {

            $user->update($validatedData);

            notyf()->success('user successfully updated.');
            return back();

        } catch (\Throwable $th) {
            throw $th;
            notyf()->error('Failed to create admin. Please try again.SCDS');
        }

        // event(new Registered($admin));
        
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        try {
            $user->delete();
            notyf()->success('user successfully deleted.');
            return back();
        } catch (\Throwable $th) {
            throw $th;
        }
        
    }

    public function active(Request $request, User $user)
    {
        // return $request;
        try {
            $user->update([
                'active' => $request->has('active') ? 1 : 0,
            ]);

            flash()->success('User successfully updated.');
            return back();

        } catch (\Throwable $th) {
            throw $th;
        }
        
    }
}
