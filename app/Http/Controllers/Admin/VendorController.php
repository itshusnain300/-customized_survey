<?php

namespace App\Http\Controllers\Admin;

// use App\Http\Controllers\Admin\Controller;

use App\Http\Requests\VendorStoreRequest;
use App\Models\User;
use App\Models\Vendor;

class VendorController extends Controller
{
    public function index()
    {
        $vendors = Vendor::latest()->paginate(10);
    
        return view('admin.vendor.index', compact('vendors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.vendor.create');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(VendorStoreRequest $request)
    {
        $validatedData = $request->validated();

        try {
            $vendor = Vendor::create($validatedData);

            // $admin->notyf(new NewadminJobRequestRecevied($admin));

            notyf()->success('New vendor successfully created.');
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
    public function show(Vendor $vendor)
    {
        // return $vendor->questions;
        $questions = $vendor->questions()->latest()->paginate(10); // Use the relation method directly
        return view('admin.vendor.show', compact('vendor', 'questions')); // Pass both variables correctly
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vendor $vendor)
    {
        return view('admin.vendor.update', compact('vendor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(VendorStoreRequest $request, Vendor $vendor)
    {
        $validatedData = $request->validated();  

        try {

            $vendor->update($validatedData);

            notyf()->success('vendor successfully updated.');
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
    public function destroy(Vendor $vendor)
    {
        try {
            $vendor->delete();
            notyf()->success('vendor successfully deleted.');
            return back();
        } catch (\Throwable $th) {
            throw $th;
        }
        
    }
}
