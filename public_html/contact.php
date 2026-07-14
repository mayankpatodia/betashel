<?php
// PHP Script for Form Submission and Database Insertion

// 1. Database Configuration (IMPORTANT: Replace with your actual credentials)
define('DB_SERVER', '127.0.0.1:3306'); // Your database server (e.g., 'localhost' or an IP address)
define('DB_USERNAME', 'u530889908_elevative_db'); // Your database username
define('DB_PASSWORD', 'M/eRg@*!Ja9'); // Your database password
define('DB_NAME', 'u530889908_elevative'); // The name of your database

// 2. Initialize variables for form feedback
$name = $email = $interests = $project_budget = $project_description = '';
$name_err = $email_err = $interests_err = $project_budget_err = $project_description_err = '';
$success_message = '';
$error_message = '';

// 3. Process form submission when it's posted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate Full Name
    if (empty(trim($_POST["full_name"]))) {
        $name_err = "Please enter your full name.";
    } else {
        $name = trim($_POST["full_name"]);
    }

    // Validate Email
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter your email address.";
    } elseif (!filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL)) {
        $email_err = "Please enter a valid email address.";
    } else {
        $email = trim($_POST["email"]);
    }

    // Validate Interests
    if (empty($_POST["interests"])) {
        $interests_err = "Please select at least one interest.";
    } else {
        // If multiple checkboxes are used, $_POST["interests"] will be an array.
        // Convert the array to a comma-separated string.
        if (is_array($_POST["interests"])) {
            $interests = implode(", ", $_POST["interests"]);
        } else {
            // If it's a single select/radio, it will be a string
            $interests = trim($_POST["interests"]);
        }
    }

    // Validate Project Budget
    if (empty(trim($_POST["project_budget"]))) {
        $project_budget_err = "Please select your project budget.";
    } else {
        $project_budget = trim($_POST["project_budget"]);
    }

    // Validate Project Description
    if (empty(trim($_POST["project_description"]))) {
        $project_description_err = "Please tell us about your project.";
    } else {
        $project_description = trim($_POST["project_description"]);
    }

    // Check if there are no validation errors before inserting into the database
    if (empty($name_err) && empty($email_err) && empty($interests_err) && empty($project_budget_err) && empty($project_description_err)) {
        // 4. Connect to MySQL database
        $mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

        // Check connection
        if ($mysqli->connect_error) {
            die("Connection failed: " . $mysqli->connect_error);
        }

        // 5. Prepare an INSERT statement to prevent SQL injection
        $sql = "INSERT INTO inquiries (full_name, email, interests, project_budget, project_description) VALUES (?, ?, ?, ?, ?)";

        if ($stmt = $mysqli->prepare($sql)) {
            // Bind parameters to the prepared statement
            $stmt->bind_param("sssss", $param_name, $param_email, $param_interests, $param_project_budget, $param_project_description);

            // Set parameters
            $param_name = $name;
            $param_email = $email;
            $param_interests = $interests;
            $param_project_budget = $project_budget;
            $param_project_description = $project_description;

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                $success_message = "Thank you! Your inquiry has been submitted successfully.";
                // Clear form fields after successful submission
                $name = $email = $interests = $project_budget = $project_description = '';
            } else {
                $error_message = "Something went wrong. Please try again later. Error: " . $stmt->error;
            }

            // Close statement
            $stmt->close();
        } else {
            $error_message = "Error preparing statement: " . $mysqli->error;
        }

        // Close connection
        $mysqli->close();
    } else {
        $error_message = "Please correct the errors in the form.";
    }
}
?>

<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-style-mode" content="1">
    
    <!-- SEO Meta Tags -->
    <title>Contact Elevative - Get Your Custom Digital Solution Quote | Love to Hear From You</title>
    <meta name="description" content="Ready to transform your digital presence? Contact Elevative for a free consultation. Call +91 983 077 8548 or email contact@elevative.xyz. Let's discuss your project today.">
    <meta name="keywords" content="contact elevative, digital agency contact, free consultation, web development quote, get in touch, project discussion">
    <meta name="author" content="Elevative - Code Verge Labs">
    <meta name="robots" content="index, follow">
    
    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="Contact Elevative - Love to Hear From You, Get in Touch!">
    <meta property="og:description" content="Ready to transform your digital presence? Contact us for a free consultation and custom project quote.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://elevative.xyz/contact.php">
    <meta property="og:image" content="https://elevative.xyz/assets/images/logo/logo-black.png">
    
    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Contact Elevative - Love to Hear From You, Get in Touch!">
    <meta name="twitter:description" content="Ready to transform your digital presence? Contact us for a free consultation and custom project quote.">
    
    <!-- Canonical URL -->
    <link rel="canonical" href="https://elevative.xyz/contact.php">
    
    <link rel="shortcut icon" type="image/x-icon" href="assets/images/logo/icon-white.png">
    <link rel="apple-touch-icon" href="assets/images/logo/icon-white.png">
    
    <link rel="stylesheet" href="assets/css/plugins/fontawesome-6.css">
    <link rel="stylesheet" href="assets/css/plugins/swiper.min.css">
    <link rel="stylesheet" href="assets/css/vendor/metismenu.css">
    <link rel="stylesheet" href="assets/css/plugins/animate.min.css">
    <link rel="stylesheet" href="assets/css/vendor/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">

    <style>
        .error-message {
            color: #ef4444; /* Tailwind red-500 */
            font-size: 14px;
            margin-top: 4px;
        }
        .success-message {
            color: #22c55e; /* Tailwind green-500 */
            font-size: 16px;
            margin-bottom: 20px;
            text-align: center;
            font-weight: 500;
        }
    </style>
</head>

<body class="inner-page contact-page">

    <!-- Scripts style two -->
    <!-- header area start -->
    <header class="header-area header-one header--sticky">
    <div class="header-container-one">
        <div class="header-wrapper">
            <a href="index.html" class="logo">
                <img src="assets/images/logo/logo-white.png" alt="logo">
            </a>
            <div class="header-right">

                <nav class="nav-area drop-down-rts">
                    <ul class="navbar-nav-1">
                        <li class="menu-item main-nav-on">
                            <a href="index.html"><span class="rolling-text">Home</span></a>
                        </li>
                        <li class="menu-item main-nav-on">
                            <a href="about.html"><span class="rolling-text">About</span></a>
                        </li>
                        <li class="menu-item main-nav-on">
                            <a href="services.html"><span class="rolling-text">Services</span></a>
                        </li>
                        <li class="menu-item main-nav-on">
                            <a href="pricing.html"><span class="rolling-text">Pricing</span></a>
                        </li>
                        <li class="menu-item main-nav-on">
                            <a href="contact.php"><span class="rolling-text">Contact</span></a>
                        </li>
                    </ul>
                </nav>

                <div class="action-area">
                    <div class="menu-btn">

                        <div class="rts-offcanvas-wrapper">
                            <div class="container-menu">
                                <div class="action-menu">
                                    <div class="close-event"></div>
                                    <div class="open-event">
                                        <!-- <div class="text">
                    <span>Menu</span>
                    <span>Close</span>
                </div> -->
                                        <div class="burger">
                                            <svg viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg" class="icon-close" data-v-649bbaab="">
                                                <line x1="13.788" y1="1.28816" x2="1.06011" y2="14.0161" stroke="currentColor" stroke-width="1.2"></line>
                                                <line x1="1.06049" y1="1.43963" x2="13.7884" y2="14.1675" stroke="currentColor" stroke-width="1.2"></line>
                                            </svg>
                                            <svg viewBox="0 0 18 12" fill="none" xmlns="http://www.w3.org/2000/svg" class="icon-burger" data-v-649bbaab="">
                                                <line x1="18" y1="0.6" y2="0.6" stroke="currentColor" stroke-width="1.2" data-v-649bbaab=""></line>
                                                <line x1="18" y1="5.7167" y2="5.7167" stroke="currentColor" stroke-width="1.2" data-v-649bbaab=""></line>
                                                <line x1="18" y1="10.8334" y2="10.8334" stroke="currentColor" stroke-width="1.2" data-v-649bbaab=""></line>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="rts-fs-menu">
                                <div class="rts-fs-container row">

                                    <div class="rts-fs--nav col-12 col-md-6">
                                        <ul id="primary-menu" class="navbar-nav-button">
                                            <li id="menu-item-76" class="menu-item">
                                                <a href="index.html">Home</a>
                                            </li>
                                            <li class="menu-item">
                                                <a href="about.html">About</a>
                                            </li>
                                            <li class="menu-item">
                                                <a href="services.html">Services</a>
                                            </li>
                                            <li class="menu-item">
                                                <a href="pricing.html">Pricing</a>
                                            </li>
                                            <li class="menu-item">
                                                <a href="contact.php">Contact</a>
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="rts-fs--contacts col-12 col-md-6">
                                        <div class="contact-inner">
                                            <div class="contact-information">
                                                <h2 class="heading-title">Get In Touch</h2>
                                                <div class="contact">
                                                    <ul>
                                                        <li><a href="mailto:contact@elevative.xyz" class="mail">contact@elevative.xyz</a></li>
                                                        <li><a href="tel:+919830778548" class="number">+91 983 077 8548</a></li>
                                                    </ul>
                                                </div>
                                                <div class="rts-social-area-one">
                                                    <ul>
                                                        <li><a href="#"><i class="fa-brands fa-facebook-f"></i></a></li>
                                                        <li><a href="#"><i class="fa-brands fa-instagram"></i></a></li>
                                                        <li><a href="#"><i class="fa-brands fa-whatsapp"></i></a></li>
                                                        <li><a href="#"><i class="fa-brands fa-linkedin"></i></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </header>
    <!-- header area end -->
    

    <!-- Scripts style two End -->

    <!-- Scripts style two -->
    <!-- rts bread crumba rea start -->
    <div class="rts-breadcrumb-area bg_image">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="baread-crumb-main-wrapper pt--100">
                        <div class="inner">
                            <span class="works">Get In Touch</span>
                            <h1 class="title rts_hero__title">Contact Now</h1>
                            <span class="bg-text">Contact Now</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- rts bread crumba rea end -->
    <!-- Scripts style two End -->


    <!-- appoinment area two start -->
    <div class="appoinmnet-area-two rts-section-gap">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <!-- appoinment area two start -->
                    <div class="appoinment-area-two plr--120 plr_md--40 plr_sm--30">
                        <div class="title-area-appoinment">
                            <span class="pre">Appointment</span>
                            <h2 class="title mb--0">
                                Love to hear from you <br>
                                <span>Get in touch!</span>
                            </h2>
                        </div>

                        <?php if (!empty($success_message)): ?>
                            <div class="success-message"><?php echo $success_message; ?></div>
                        <?php endif; ?>
                        <?php if (!empty($error_message) && empty($success_message)): ?>
                            <div class="general-error-message"><?php echo $error_message; ?></div>
                        <?php endif; ?>
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="appoinment-h2 rts-slide-up-gsap" method="post">
                            <div class="input-line">
                                <div class="input-half">
                                    <label for="full_name">Your Name*</label>
                                    <input id="full_name" type="text" name="full_name" placeholder="Your full name" value="<?php echo htmlspecialchars($name); ?>" required>
                                    <span class="error-message"><?php echo $name_err; ?></span>
                                </div>
                                <div class="input-half">
                                    <label for="email">Your Email*</label>
                                    <input id="email" name="email" type="text" placeholder="your.email@company.com" value="<?php echo htmlspecialchars($email); ?>" required>
                                    <span class="error-message"><?php echo $email_err; ?></span>
                                </div>
                            </div>
                            <div class="input-line mt--40">
                                <div class="input-half">
                                    <label for="interests">What interests you most?*</label>
                                    <select class="form-select" name="interests[]" id="interests" aria-label="Service selection" value="<?php echo htmlspecialchars($interests); ?>" required>
                                        <option value="Web Development" <?php echo (strpos($interests, 'Web Development') !== false) ? 'selected' : ''; ?>>Web Development</option>
                                        <option value="Branding" <?php echo (strpos($interests, 'Branding') !== false) ? 'selected' : ''; ?>>Branding</option>
                                        <option value="Marketing" <?php echo (strpos($interests, 'Marketing') !== false) ? 'selected' : ''; ?>>Marketing</option>
                                        <option value="Logo Design" <?php echo (strpos($interests, 'Logo Design') !== false) ? 'selected' : ''; ?>>Logo Design</option>
                                        <option value="Graphic Designing" <?php echo (strpos($interests, 'Graphic Designing') !== false) ? 'selected' : ''; ?>>Graphic Designing</option>
                                        <option value="App Development" <?php echo (strpos($interests, 'App Development') !== false) ? 'selected' : ''; ?>>App Development</option>
                                        <option value="WhatsApp Marketing" <?php echo (strpos($interests, 'WhatsApp Marketing') !== false) ? 'selected' : ''; ?>>WhatsApp Marketing</option>
                                        <option value="SEO" <?php echo (strpos($interests, 'SEO') !== false) ? 'selected' : ''; ?>>SEO</option>
                                        <option value="End-to-End Project Management" <?php echo (strpos($interests, 'End-to-End Project Management') !== false) ? 'selected' : ''; ?>>End-to-End Project Management</option>
                                    </select>
                                    <span class="error-message"><?php echo $interests_err; ?></span>
                                </div>
                                <div class="input-half">
                                    <label for="project_budget">Project Budget*</label>
                                    <select class="form-select" name="project_budget" id="project_budget" aria-label="Budget selection" value="<?php echo htmlspecialchars($project_budget); ?>" required>
                                        <option value="">Select a budget range</option>
                                        <option value="₹20,000 - ₹50,000" <?php echo ($project_budget == '₹20,000 - ₹50,000') ? 'selected' : ''; ?>>₹20,000 - ₹50,000</option>
                                        <option value="₹50,001 - ₹1,00,000" <?php echo ($project_budget == '₹50,001 - ₹1,00,000') ? 'selected' : ''; ?>>₹50,001 - ₹1,00,000</option>
                                        <option value="₹1,00,001 - ₹2,00,000" <?php echo ($project_budget == '₹1,00,001 - ₹2,00,000') ? 'selected' : ''; ?>>₹1,00,001 - ₹2,00,000</option>
                                        <option value="₹2,00,001+" <?php echo ($project_budget == '₹2,00,001+') ? 'selected' : ''; ?>>₹2,00,001+</option>
                                        <option value="Custom Budget" <?php echo ($project_budget == 'Custom Budget') ? 'selected' : ''; ?>>Custom Budget</option>
                                    </select>
                                    <span class="error-message"><?php echo $project_budget_err; ?></span>
                                </div>
                            </div>
                            <div class="text-area mt--40">
                                <label for="project_description">Tell us about your project*</label>
                                <textarea id="project_description" name="project_description" cols="30" rows="10" placeholder="Describe your vision, goals, and any specific requirements. The more details you provide, the better we can tailor our proposal to your needs." value="<?php echo htmlspecialchars($project_description); ?>" required></textarea>
                                <span class="error-message"><?php echo $project_description_err; ?></span>
                            </div>
                            <button type="submit" class="submit-pd">Send Project Inquiry</button>
                        </form>
                    </div>
                    <!-- appoinment area two end -->
                </div>
            </div>
        </div>
    </div>
    <!-- appoinment area two end -->




    <!-- rts footer two area start -->
    <div class="rts-footer-two-area bg-footer-2 bg_image-1">
        <div class="container-140">
            <div class="row">
                <div class="col-lg-12 pt--130 pt_sm--60 pb--100 pb_sm--60">
                    <div class="footer-two-wrapper-content">
                        <!-- footer left start -->
                        <div class="footer-left-two">
                            <a href="index.html" class="logo">
                                <img src="assets/images/logo/logo-white.png" alt="logo">
                            </a>
                            <p class="disc">
                                Teor facilis porta maurs ligula vivamus <br> nullam laoreet pharetra posuere.
                            </p>
                            <div class="rts-social-area-one">
                                <ul>
                                    <li><a href="#"><i class="fa-brands fa-facebook-f"></i></a></li>
                                    <li><a href="#"><i class="fa-brands fa-instagram"></i></a></li>
                                    <li><a href="#"><i class="fa-brands fa-whatsapp"></i></a></li>
                                    <li><a href="#"><i class="fa-brands fa-linkedin"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <!-- footer left end -->

                        <!-- footer right area start -->
                        <div class="footer-right-two">
                            <!-- contact info -->
                            <div class="contact-information">
                                <h5 class="title">Contact Info</h5>
                                <a href="mailto:contact@elevative.xyz" class="mail">contact@elevative.xyz</a>
                                <a href="tel:+919830778548" class="number">+91 983 077 8548</a>
                                <a href="#" class="map">India</a>
                            </div>
                            <!-- contact info end -->
                            <!-- contact info -->
                            <div class="contact-information input">
                                <h5 class="title">Subscribe Newsletter</h5>
                                <p class="map">Subscribe our newsletter for future updates. don’t <br> worry we don’t spam your email address</p>
                                <form action="#" class="form-footer-2">
                                    <label for="email-1"><i class="fa-regular fa-envelope"></i></label>
                                    <input id="email-1" type="email" placeholder="Enter your email..." required>
                                    <button type="submit">Subscribe</button>
                                </form>
                            </div>
                            <!-- contact info end -->
                        </div>
                        <!-- footer right area end -->
                    </div>
                </div>
                <div class="col-lg-12">
                    <!-- copyright-area-start -->
                    <div class="copy-right-area-start-two">
                        <p class="left">2025 © Code Verge Labs. All rights reserved.</p>
                    </div>
                    <!-- copyright-area-end -->
                </div>
            </div>
        </div>
    </div>
    <!-- rts footer two area end -->


    <!-- Scripts style two -->
    <div class="loading-screen" id="loading-screen">
        <span class="bar top-bar"></span>
        <span class="bar down-bar"></span>
        <span class="progress-line"></span>
        <span class="loading-counter"> </span>
    </div>


    <div class="bg-noise"></div>


    <!-- back to top start -->
    <div class="progress-wrap">
        <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98"></path>
        </svg>
    </div>
    <!-- back to top end -->



    <!-- pre loader start -->
    <div class="rts-cursor cursor-outer" data-default="yes" data-link="yes" data-slider="no">
        <span class="fn-cursor"></span>
    </div>
    <div class="rts-cursor cursor-inner" data-default="yes" data-link="yes" data-slider="no">
        <span class="fn-cursor">
        <span class="fn-left"></span>
        <span class="fn-right"></span>
        </span>
    </div>
    <!-- pre loader end -->



    <!-- dark light switcher start-->
    <div class="modal-sidebar-scroll rts-dark-light">
        <ul>
            <li class="go-dark-w"><span>Dark</span><i class="rts-go-dark fal fa-moon"></i></li>
            <li class="go-light-w"><span>Light</span><i class="rts-go-light fa-light fa-brightness"></i></li>
        </ul>
    </div>
    <!-- dark light switcher end -->



    <script defer src="assets/js/vendor/jquery.min.js"></script>
    <script defer src="assets/js/plugins/bootstrap.min.js"></script>
    <script defer src="assets/js/plugins/contact.form.js"></script>
    <script defer src="assets/js/vendor/waypoint.js"></script>
    <script defer src="assets/js/plugins/swiper.js"></script>


    <!-- for side bar sticky -->
    <script defer src="assets/js/plugins/resizer-sensor.js"></script>
    <script defer src="assets/js/plugins/sticky-sidebar.js"></script>
    <!-- for side bar sticky end-->

    <script defer src="assets/js/plugins/isotop.js"></script>
    <script defer src="assets/js/plugins/imagesloaded.pkgd.min.js"></script>

    <script defer src="assets/js/plugins/smoothscroll-varticle.js"></script>
    <script defer src="assets/js/vendor/gsap.js"></script>
    <script defer src="assets/js/plugins/scrolltrigger.js"></script>
    <script defer src="assets/js/plugins/scrolltoplugin.js"></script>
    <script defer src="assets/js/plugins/splittext.js"></script>
    <script defer src="assets/js/plugins/smoothscroll.js"></script>

    <!-- title opacity scroll magix -->
    <script defer src="assets/js/plugins/scrollmagic.js"></script>
    <script defer src="assets/js/plugins/animate-scrollmagic.js"></script>
    <!-- title opacity scroll magic end -->



    <script defer src="assets/js/plugins/tilt.js"></script>
    <script defer src="assets/js/plugins/counterup.js"></script>

    <script defer src="assets/js/vendor/wow.js"></script>
    <!-- custom javascripts -->
    <script defer src="assets/js/main.js"></script>
    <!-- Scripts style two End -->
</body>

</html>