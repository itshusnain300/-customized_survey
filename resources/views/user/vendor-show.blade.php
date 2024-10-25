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
                <div class="col-lg-8 offset-lg-2 mb-4">
                    <div class="card py-5">
                        <div class="card-body">
                            <h5 class="card-title">Vendor Questionnaire</h5>
        
                            <!-- Question 1: Yes/No -->
                            <div class="form-group">
                                <p><strong>1. Do you have a valid business license?</strong></p>
                                <p>Type: Yes/No</p>
                            </div>
        
                            <!-- Question 2: Multiple Choice -->
                            <div class="form-group">
                                <p><strong>2. What services does your business provide?</strong></p>
                                <p>Type: Multiple Choice</p>
                            </div>
        
                            <!-- Question 3: Text Input -->
                            <div class="form-group">
                                <p><strong>3. Please describe your business model:</strong></p>
                                <p>Type: Text Input</p>
                            </div>
        
                            <!-- Question 4: Multiple Checkbox Options -->
                            <div class="form-group">
                                <p><strong>4. What types of payment methods do you accept?</strong></p>
                                <p>Type: Checkbox Options</p>
                            </div>
        
                            <!-- Question 5: Radio Button Selection -->
                            <div class="form-group">
                                <p><strong>5. How did you hear about our services?</strong></p>
                                <p>Type: Radio Button</p>
                            </div>
        
                            <!-- Question 6: Rating Scale -->
                            <div class="form-group">
                                <p><strong>6. How would you rate our customer service?</strong></p>
                                <p>Type: Rating Scale (1-5)</p>
                            </div>
        
                            <!-- Question 7: Date Input -->
                            <div class="form-group">
                                <p><strong>7. When did you start your business?</strong></p>
                                <p>Type: Date Input</p>
                            </div>
        
                            <!-- Question 8: File Upload -->
                            <div class="form-group">
                                <p><strong>8. Upload a copy of your business license:</strong></p>
                                <p>Type: File Upload</p>
                            </div>
        
                            <!-- Question 9: Email Input -->
                            <div class="form-group">
                                <p><strong>9. Enter your business email:</strong></p>
                                <p>Type: Email Input</p>
                            </div>
        
                            <!-- Question 10: Number Input -->
                            <div class="form-group">
                                <p><strong>10. How many employees do you have?</strong></p>
                                <p>Type: Number Input</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        

    </main>
@endsection
