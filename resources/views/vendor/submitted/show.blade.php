<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Survey System</title>
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">

    <!-- =======================================================
  * Template Name: Bootslander
  * Template URL: https://bootstrapmade.com/bootslander-free-bootstrap-landing-page-template/
  * Updated: Aug 07 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

@php
            // return dd($submitted_vendor);
            $questions = $submitted_vendor->questions;
            $totalWeight = 0;
            $totalScore = 0;

            foreach ($questions as $question) {
                $answer = $question->userAnswer($userId); // Assuming 'answer' is the relation to the Answer model

                if ($answer) {
                    $totalScore += $answer->score;
                }

                if ($question->type == 'multiple_choice') {
                    $q_opts = $question->options;
                    foreach ($q_opts as $q_opt) {
                        $totalWeight += $q_opt->weight;
                    }
                } else {
                    $totalWeight += $question->weight;
                }
            }

            // Calculate the percentage only after the loop
            $totalScorePer = $totalWeight > 0 ? ($totalScore / $totalWeight) * 100 : 0;

            // @dd($totalWeight);

        @endphp

<body class="index-page">

    <header id="header" class="header d-flex align-items-center fixed-top">
        <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

            <a href="index.html" class="logo d-flex align-items-center">
                <!-- Uncomment the line below if you also wish to use an image logo -->
                <!-- <img src="assets/img/logo.png" alt=""> -->
                <h1 class="sitename">Surveyor</h1>
            </a>

            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="#hero" class="active">Home</a></li>
                    <li><a href="#about">About</a></li>
                    <li><a href="#features">Solutions</a></li>
                    <li><a href="#pricing">Pricing</a></li>
                    <li><a href="#contact">Contact</a></li>
                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>

        </div>
    </header>

    <main id="main" class="main">
        <section class="container mt-5">
            <!-- Company Logo -->
            <div class="text-center mb-4">
                <img src="{{ asset('assets/img/fill-online-surveys-google-forms-questionnaire-and-polls.png') }}"
                    alt="Company Logo" class="company-logo">
            </div>

            <!-- Header -->
            <h2 class="text-center mb-4">User Submitted Questions & Answers,.,..,,.</h2>

            <h2 class="text-end mb-4">
                Total Score: {{ number_format($totalScorePer, 2) }}% [{{ $totalWeight }}]
            </h2>

            <h5 class="text-end mb-4">
                @if ($user->teamUser($user) && $user->teamUser($user)->submittedVendors->isNotEmpty())
                    Average: {{ $average }}%
                @else
                    Notes: No submissions from your team user yet.
                @endif
            </h5>


            <!-- List of Questions and Answers -->
            @foreach ($questions as $question)
                <div class="answer-box p-4 shadow-sm">
                    <!-- Question -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0">{{ $question->title }}</h5>
                        <div>
                            <!-- Icons based on question type -->
                            @if ($question->type == 'open_text')
                                <i class="fas fa-keyboard question-type-icon" title="Open Text"></i>
                            @elseif($question->type == 'multiple_choice')
                                <i class="fas fa-list-ul question-type-icon" title="Multiple Choice"></i>
                            @elseif($question->type == 'yes_no')
                                <i class="fas fa-check-circle question-type-icon" title="Yes/No"></i>
                            @elseif($question->type == 'valid_failed')
                                <i class="fas fa-times-circle question-type-icon" title="Valid/Failed"></i>
                            @elseif($question->type == 'file')
                                <i class="fas fa-file-upload question-type-icon" title="File"></i>
                            @endif
                        </div>
                    </div>

                    @php
                        // Retrieve the user's answer as a comma-separated string
                        $userAnswer = $question->userAnswer($userId)->answer_text ?? null;
                        $q_score = $question->userAnswer($userId)->score ?? null;

                    @endphp

                    <!-- Answer Section -->
                    <div class="mb-2">
                        <span class="answer-label">Answer:</span>

                        <!-- Display based on the type of question -->
                        @if ($question->type == 'text')
                            <p>{{ $userAnswer }}</p>
                        @elseif($question->type == 'multiple_choice')
                            @if ($userAnswer)
                                <ul>
                                    @foreach (explode(',', $userAnswer) as $answer)
                                        <li>{{ trim($answer) }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <li>No Answer Submitted</li>
                            @endif
                        @elseif($question->type == 'yes_no')
                            <p>{{ $question->userAnswer($userId) && $question->userAnswer($userId)->answer_text }}
                            </p>
                        @elseif($question->type == 'valid_failed')
                            <p>{{ $answer_text == '1' ? 'Valid' : 'Failed' }}</p>
                        @elseif($question->type == 'file')
                            <a href="{{ asset('storage/uploads/' . $answer_file) }}" target="_blank"
                                class="btn btn-sm btn-primary">
                                <i class="fas fa-download"></i> Download File
                            </a>
                        @endif
                    </div>

                    <div class="mb-2">
                        <span class="answer-label">Score:</span>

                        <p>{{ $q_score ?? 'No Score' }}</p>
                    </div>

                    <!-- Submission Metadata (optional) -->
                    {{-- <div class="text-muted">
                    <small>Submitted by {{ $user->name }} on {{ $user->created_at->format('d M Y, h:i A') }}</small>
                </div> --}}
                </div>
            @endforeach
        </section>

    </main>

    <footer id="footer" class="footer dark-background">

        <div class="container footer-top">
            <div class="row gy-4">
                <div class="col-lg-4 col-md-6 footer-about">
                    <a href="index.html" class="logo d-flex align-items-center">
                        <span class="sitename">Bootslander</span>
                    </a>
                    <div class="footer-contact pt-3">
                        <p>A108 Adam Street</p>
                        <p>New York, NY 535022</p>
                        <p class="mt-3"><strong>Phone:</strong> <span>+1 5589 55488 55</span></p>
                        <p><strong>Email:</strong> <span>info@example.com</span></p>
                    </div>
                    <div class="social-links d-flex mt-4">
                        <a href=""><i class="bi bi-twitter-x"></i></a>
                        <a href=""><i class="bi bi-facebook"></i></a>
                        <a href=""><i class="bi bi-instagram"></i></a>
                        <a href=""><i class="bi bi-linkedin"></i></a>
                    </div>
                </div>

                <div class="col-lg-2 col-md-3 footer-links">
                    <h4>Useful Links</h4>
                    <ul>
                        <li><a href="#">Home</a></li>
                        <li><a href="#">About us</a></li>
                        <li><a href="#">Services</a></li>
                        <li><a href="#">Terms of service</a></li>
                        <li><a href="#">Privacy policy</a></li>
                    </ul>
                </div>

                <div class="col-lg-2 col-md-3 footer-links">
                    <h4>Our Services</h4>
                    <ul>
                        <li><a href="#">Web Design</a></li>
                        <li><a href="#">Web Development</a></li>
                        <li><a href="#">Product Management</a></li>
                        <li><a href="#">Marketing</a></li>
                        <li><a href="#">Graphic Design</a></li>
                    </ul>
                </div>

                <div class="col-lg-4 col-md-12 footer-newsletter">
                    <h4>Our Newsletter</h4>
                    <p>Subscribe to our newsletter and receive the latest news about our products and services!</p>
                    <form action="forms/newsletter.php" method="post" class="php-email-form">
                        <div class="newsletter-form"><input type="email" name="email"><input type="submit"
                                value="Subscribe"></div>
                        <div class="loading">Loading</div>
                        <div class="error-message"></div>
                        <div class="sent-message">Your subscription request has been sent. Thank you!</div>
                    </form>
                </div>

            </div>
        </div>

        <div class="container copyright text-center mt-4">
            <p>© <span>Copyright</span> <strong class="px-1 sitename">Bootslander</strong> <span>All Rights
                    Reserved</span></p>
            <div class="credits">
                <!-- All the links in the footer should remain intact. -->
                <!-- You can delete the links only if you've purchased the pro version. -->
                <!-- Licensing information: https://bootstrapmade.com/license/ -->
                <!-- Purchase the pro version with working PHP/AJAX contact form: [buy-url] -->
                Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
            </div>
        </div>

    </footer>

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Preloader -->
    {{-- <div id="preloader"></div> --}}

    <!-- Vendor JS Files -->
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>
    <script src="assets/vendor/aos/aos.js"></script>
    <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>

    <!-- Main JS File -->
    <script src="assets/js/main.js"></script>

</body>

</html>
