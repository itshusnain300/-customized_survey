<?php

namespace App\Http\Controllers\Admin;

// use App\Http\Controllers\Admin\Controller;

use App\Http\Requests\CompanyStoreRequest;
use App\Models\Company;
use App\Models\User;
use App\Models\UserCompany;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserCompanyController extends Controller
{
    
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'company_id' => ['required', 'exists:companies,id'],
            'user_type' => ['required', 'in:user,customer'],
        ]);
    
        try {

            $user = User::findOrFail( $validatedData['user_id']);
            $company = Company::findOrFail( $validatedData['company_id']);
            // Assign or update the company with user details
            $companyAssignment = UserCompany::updateOrCreate(
                ['user_id' => $validatedData['user_id']],
                [
                    'company_id' => $validatedData['company_id'],
                    'user_type' => $validatedData['user_type'],
                ]
            );
    
            $user->company = $company->name;
            $user->save();
    
            $message = $companyAssignment->wasRecentlyCreated 
                ? 'Company successfully assigned to user.'
                : 'Company assignment successfully updated.';
    
            notyf()->success($message);
            return back();
    
        } catch (\Throwable $th) {
            Log::error($th);
            notyf()->error('Failed to assign or update company. Please try again.');
            return back()->withErrors('An error occurred. Please try again later.');
        }
    }
    
}
