@extends('admin.layouts.app')
@section('main')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Dashboard</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </nav>
        </div>


        <section class="section">
            <div class="row">
        
                <div class="col-lg-4 mb-4">
                    <div class="card py-5">
                        <div class="card-body text-center">
                            <h5 class="card-title">Vendor 1</h5>
                            <p>Information about the vendor goes here. This could include details about the services offered, location, etc.</p>
                            <a href="{{ route('admin.vendor.show') }}" class="btn btn-primary" onclick="toggleQuestions('vendor1Questions')">Show Questions</a>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 mb-4">
                    <div class="card py-5">
                        <div class="card-body text-center">
                            <h5 class="card-title">Vendor 2</h5>
                            <p>Information about the vendor goes here. This could include details about the services offered, location, etc.</p>
                            <button class="btn btn-primary" onclick="toggleQuestions('vendor1Questions')">Show Questions</button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-4">
                    <div class="card py-5">
                        <div class="card-body text-center">
                            <h5 class="card-title">Vendor 3</h5>
                            <p>Information about the vendor goes here. This could include details about the services offered, location, etc.</p>
                            <button class="btn btn-primary" onclick="toggleQuestions('vendor1Questions')">Show Questions</button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-4">
                    <div class="card py-5">
                        <div class="card-body text-center">
                            <h5 class="card-title">Vendor 1</h5>
                            <p>Information about the vendor goes here. This could include details about the services offered, location, etc.</p>
                            <button class="btn btn-primary" onclick="toggleQuestions('vendor1Questions')">Show Questions</button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-4">
                    <div class="card py-5">
                        <div class="card-body text-center">
                            <h5 class="card-title">Vendor 4</h5>
                            <p>Information about the vendor goes here. This could include details about the services offered, location, etc.</p>
                            <button class="btn btn-primary" onclick="toggleQuestions('vendor1Questions')">Show Questions</button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-4">
                    <div class="card py-5">
                        <div class="card-body text-center">
                            <h5 class="card-title">Vendor 5</h5>
                            <p>Information about the vendor goes here. This could include details about the services offered, location, etc.</p>
                            <button class="btn btn-primary" onclick="toggleQuestions('vendor1Questions')">Show Questions</button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-4">
                    <div class="card py-5">
                        <div class="card-body text-center">
                            <h5 class="card-title">Vendor 6</h5>
                            <p>Information about the vendor goes here. This could include details about the services offered, location, etc.</p>
                            <button class="btn btn-primary" onclick="toggleQuestions('vendor1Questions')">Show Questions</button>
                        </div>
                    </div>
                </div>
                
            </div>
        </section>
        

    </main>
@endsection
