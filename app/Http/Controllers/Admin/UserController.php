<?php
namespace App\Http\Controllers\Admin;

use App\Http\Requests\UserStoreRequest;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        // $users = User::with('company')->latest()->get();
        $users = User::with('company')->latest()->paginate(10);
        // $users = User::with('company')->latest()->get();
        return view('admin.user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Get companies that are not assigned to any user
        // $companies = Company::doesntHave('user')->latest()->get(); // Only companies without users assigned

        return view('admin.user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserStoreRequest $request)
    {

        // Validate incoming data (already done by the UserStoreRequest)
        $validatedData = $request->validated();

        try {
            // Check if the company is already assigned to another user
            if ($request->has('company_id') && $request->company_id) {
                $company = Company::find($request->company_id);

                if ($company && $company->user()->count() > 0) {
                    // If the company already has an assigned user, abort
                    return back()->withErrors(['company_id' => 'This company is already assigned to another user.']);
                }
            }

            // Create the user with the validated data
            $user = User::create($validatedData);

            // // If a company is assigned, associate it with the user
            // if ($request->has('company_id') && $request->company_id) {
            //     $user->companies()->attach($request->company_id); // For many-to-many relationship
            // }

            // Notify user about success
            notyf()->success('New user successfully created.');

            // Redirect back to the form with a success message
            return back();

        } catch (\Throwable $th) {
            // Handle any exceptions and notify failure
            notyf()->error('Failed to create user. Please try again.');
            throw $th; // Optionally, log or handle the exception further
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('admin.user.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        // Get the list of companies that are not assigned to any user
        // $companies = Company::doesntHave('user')->latest()->get();

        return view('admin.user.update', compact('user', 'companies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserStoreRequest $request, User $user)
    {
        // Validate incoming data (already done in the request)
        $validatedData = $request->validated();

        try {
            // If a company is assigned during the update, associate it
            if ($request->has('company_id') && $request->company_id) {
                $company = Company::find($request->company_id);

                // Ensure the company is not already assigned to another user
                if ($company && $company->user()->count() > 0 && $company->user->id != $user->id) {
                    return back()->withErrors(['company_id' => 'This company is already assigned to another user.']);
                }

                // Attach or update the company assignment
                // $user->companies()->sync([$request->company_id]); // Sync ensures only one company is assigned
            }

            // Update user details
            $user->update($validatedData);

            // Notify user about success
            notyf()->success('User successfully updated.');

            // Redirect back to the form with a success message
            return back();

        } catch (\Throwable $th) {
            // Handle any exceptions and notify failure
            notyf()->error('Failed to update user. Please try again.');
            throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        try {
            $user->delete();
            notyf()->success('User successfully deleted.');
            return back();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function active(Request $request, User $user)
    {
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
