<?php

namespace App\Http\Controllers\Admin;

// use App\Http\Controllers\Admin\Controller;

use App\Http\Requests\CompanyStoreRequest;
use App\Models\Company;
use App\Models\CompanySets;
use App\Models\Vendor;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::latest()->paginate(10);
    
        return view('admin.company.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $vendors = Vendor::latest()->get();
        return view('admin.company.create', compact('vendors'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(CompanyStoreRequest $request)
    {
        $validatedData = $request->validated();

        try {
            $company = Company::create($validatedData);

            CompanySets::create([
                'company_id' => $company->id,
                'vendor_id' => $validatedData['basic_set'],
            ]);
            CompanySets::create([
                'company_id' => $company->id,
                'vendor_id' => $validatedData['advanced_set'],
            ]);
            CompanySets::create([
                'company_id' => $company->id,
                'vendor_id' => $validatedData['customer_specific'],
            ]);

            // $admin->notyf(new NewadminJobRequestRecevied($admin));

            notyf()->success('New company successfully created.');
            return back();

        } catch (\Throwable $th) {
            throw $th;
            notyf()->error('Failed to create admin. Please try again.SCDS');
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        // return $company->submittedVendors->map->vendor;
        return view('admin.company.show', compact('company', )); // Pass both variables correctly
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company)
    {
        $vendors = Vendor::latest()->get();
        return view('admin.company.update', compact('company', 'vendors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CompanyStoreRequest $request, Company $company)
    {
        $validatedData = $request->validated();  

        try {

            $company->update($validatedData);

            notyf()->success('company successfully updated.');
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
    public function destroy(Company $company)
    {
        try {
            $company->delete();
            notyf()->success('company successfully deleted.');
            return back();
        } catch (\Throwable $th) {
            throw $th;
        }
        
    }
}
