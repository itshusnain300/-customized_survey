<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Surveyor</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css"
        integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('assets/css/auth.css') }}" />
</head>

<body>

    <div class="container" id="container">
        <div class="form-container sign-in-container">
            <form method="POST" action="{{ route('register') }}">
                
                @csrf
                <h1>Create Account</h1>
                <div class="social-container">
                    <a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social"><i class="fab fa-google-plus-g"></i></a>
                    <a href="#" class="social"><i class="fab fa-linkedin-in"></i></a>
                </div>


                @if ($errors->any())
                    <div class="alert alert-danger mt-4">
                        <strong>Please fix the following errors:</strong>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li class="text-error">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <span>or use your email for registration</span>
                <input name="name" type="text" placeholder="Name" />
                <input name="email" type="email" placeholder="Email" />
                <input name="password" type="password" placeholder="Password" />
                <input name="password_confirmation" type="password" placeholder="Confirm Password" />

                {{-- --####### // Hidden Inout // ####### --*/ --}}
                <input name="type" type="hidden" value="customer" />
                <input name="packageId" type="hidden" value="{{ $package->id }}" />
                <button>Sign Up</button>
            </form>
        </div>
        <div class="form-container  sign-up-container">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <h1>Sign in</h1>
                <div class="social-container">
                    <a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social"><i class="fab fa-google-plus-g"></i></a>
                    <a href="#" class="social"><i class="fab fa-linkedin-in"></i></a>
                </div>
                <span>or use your account</span>

                @if ($errors->any())
                    <div class="alert alert-danger mt-4">
                        <strong>Please fix the following errors:</strong>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li class="text-error">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif


                <input name="email" type="email" placeholder="Email" />
                <input name="password" type="password" placeholder="Password" />
                <a href="#">Forgot your password?</a>
                <button>Sign In</button>
            </form>
        </div>
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1>Welcome Back!</h1>
                    <p>To keep connected with us please login with your personal info</p>
                    <button class="ghost" id="signIn">Sign In</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1>Hello, Friend!</h1>
                    <p>Enter your personal details and start journey with us</p>
                </div>
            </div>
        </div>
    </div>

    <div class="footer">
        <b> Survey Management</b>
        <div class="icons">
            <a href="https://github.com/kvaibhav01" target="_blank" class="social"><i class="fab fa-github"></i></a>
            <a href="https://www.instagram.com/vaibhavkhulbe143/" target="_blank" class="social"><i
                    class="fab fa-instagram"></i></a>
            <a href="https://medium.com/@vaibhavkhulbe" target="_blank" class="social"><i class="fab fa-medium"></i></a>
            <a href="https://twitter.com/vaibhav_khulbe" target="_blank" class="social"><i
                    class="fab fa-twitter-square"></i></a>
            <a href="https://linkedin.com/in/vaibhav-khulbe/" target="_blank" class="social"><i
                    class="fab fa-linkedin"></i></a>
        </div>
    </div>
</body>

{{-- <script src="{{ asset('assets/js/auth.js') }}"></script> --}}

</html>
