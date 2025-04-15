<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GearGuard - Professional Vehicle Maintenance</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --text: #f5f5f5;
            --background: #181a20;
            --primary: #C0C0C0;
            --secondary: #25272d;
            --accent: #2463eb;
            --hover-bg: rgba(36, 99, 235, 0.1);
            --border: #33363f;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--background);
            color: var(--text);
            line-height: 1.6;
            overflow-x: hidden;
        }

        .container {
            background-color: var(--secondary);
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 15px;
        }

        Navigation .navbar {
            background-color: transparent;
            backdrop-filter: blur(10px);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
            transition: background-color 0.3s ease;
        }

        .navbar-content {
            background-color: transparent;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 0;


        }

        .logo {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--accent);
            transition: transform 0.2s ease;
        }

        .logo:hover {
            transform: scale(1.05);
        }

        .nav-links {
            display: flex;
            gap: 1.5rem;
        }

        .nav-links a {
            text-decoration: none;
            color: var(--primary);
            font-weight: 500;
            transition: color 0.3s ease, transform 0.2s ease;
            position: relative;
        }

        .nav-links a::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -5px;
            left: 0;
            background-color: var(--accent);
            transition: width 0.3s ease;
        }

        .nav-links a:hover {
            color: var(--accent);
        }

        .nav-links a:hover::after {
            width: 100%;
        }

        /* Hero Section */
        .hero {
            margin-top: 70px;
            position: relative;
            height: 100vh;
            display: flex;
            align-items: center;
            overflow: hidden;
        }

        /* Carousel Styles */
        .carousel {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        .carousel-slide {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            transition: opacity 0.5s ease;
            background-size: cover;
            background-position: center;
        }

        .carousel-slide.active {
            opacity: 1;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            background-color: rgba(0, 0, 0, 0.3);
            padding: 2rem;
            border-radius: 12px;
            max-width: 1200px;
            max-height: 600px;
            margin: 0 auto;
            text-align: center;
            align-items: center;
            justify-content: center;
            margin-top: 200px;
            transform: translateY(20px);
            opacity: 0;
            transition: transform 0.5s ease, opacity 0.5s ease;
        }

        .carousel-slide.active .hero-content {
            transform: translateY(0);
            opacity: 1;
        }

        .hero-content h1 {
            font-size: 3.5rem;
            margin-bottom: 1rem;
            color: var(--primary);
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        .hero-content p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            color: var(--primary);
        }

        .cta-button {
            display: inline-block;
            background-color: var(--accent);
            color: var(--text);
            padding: 0.75rem 1.5rem;
            text-decoration: none;
            border-radius: 8px;
            transition: background-color 0.3s ease, transform 0.2s ease;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .cta-button:hover {
            background-color: #1b4ebd;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(36, 99, 235, 0.3);
        }

        /* Section Styles */
        .section {
            padding: 6rem 0;
            background-color: var(--secondary);
        }

        .section-title {
            text-align: center;
            margin-bottom: 3rem;
            color: var(--primary);
            position: relative;
            font-size: 2.5rem;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 3px;
            background-color: var(--accent);
        }

        /* Services */
        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
        }

        .service-card {
            background-color: var(--background);
            padding: 2rem;
            border-radius: 12px;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .service-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
        }

        .service-card img {
            max-width: 100px;
            margin-bottom: 1rem;
            filter: grayscale(30%) brightness(120%);
            transition: transform 0.3s ease;
        }

        .service-card:hover img {
            transform: scale(1.1);
        }

        .service-card h3 {
            color: var(--accent);
            margin-bottom: 1rem;
        }

        /* Customer Feedback */
        .feedback-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
        }

        .feedback-card {
            background-color: var(--background);
            padding: 2rem;
            border-radius: 12px;
            text-align: center;
            border: 1px solid var(--border);
            transition: transform 0.3s ease;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .feedback-card:hover {
            transform: translateY(-5px);
        }

        .feedback-card img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin-bottom: 1rem;
            object-fit: cover;
            border: 3px solid var(--accent);
        }

        .feedback-card p {
            font-style: italic;
            margin-bottom: 1rem;
        }

        .feedback-card h4 {
            color: var(--accent);
        }

        /* Contact Form */
        .contact-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .contact-form {
            background-color: var(--background);
            padding: 2rem;
            border-radius: 12px;
        }

        .contact-form input,
        .contact-form textarea {
            width: 100%;
            padding: 0.75rem;
            margin-bottom: 1rem;
            background-color: var(--secondary);
            border: 1px solid var(--border);
            border-radius: 8px;
            color: var(--text);
            transition: border-color 0.3s ease;
        }

        .contact-form input:focus,
        .contact-form textarea:focus {
            outline: none;
            border-color: var(--accent);
        }

        /* Footer */
        .footer {
            background-color: var(--secondary);
            color: var(--text);
            padding: 2rem 0;
            text-align: center;
        }

        .footer a {
            color: var(--accent);
            margin: 0 10px;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer a:hover {
            color: var(--primary);
        }

        .carousel-controls {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 10px;
            z-index: 10;
        }

        .carousel-dot {
            width: 12px;
            height: 12px;
            background-color: rgba(255, 255, 255, 0.5);
            border-radius: 50%;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .carousel-dot.active {
            background-color: var(--accent);
            transform: scale(1.2);
        }

        .contact-details {
            background-color: var(--background);
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        .contact-details h3,
        .contact-details p {
            color: var(--primary);
        }

        .contact-details h4 {
            margin-top: 1.5rem;
            color: var(--accent);
        }

        .social-links {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-top: 1rem;
        }

        .social-links a {
            color: var(--accent);
            font-size: 1.5rem;
            transition: color 0.3s ease, transform 0.2s ease;
        }

        .social-links a:hover {
            color: var(--primary);
            transform: translateY(-3px);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .hero-content h1 {
                font-size: 2.5rem;
            }

            .nav-links {
                display: none;
            }

            .mobile-menu-btn {
                display: block;
            }
        }

        .mobile-menu-btn {
            display: none;
            background: none;
            border: none;
            color: var(--primary);
            font-size: 1.5rem;
            cursor: pointer;
        }

        @media (max-width: 768px) {
            .mobile-menu-btn {
                display: block;
            }

            .nav-links {
                display: none;
                position: absolute;
                top: 100%;
                left: 0;
                width: 100%;
                background-color: var(--secondary);
                flex-direction: column;
                padding: 1rem;
            }

            .nav-links.active {
                display: flex;
            }
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes slideInFromBottom {
            from {
                transform: translateY(50px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .fade-in {
            animation: fadeIn 1s ease-out;
        }

        .slide-in {
            animation: slideInFromBottom 0.5s ease-out;
        }

        .logo img {
            max-height: 50px;
            object-fit: contain;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <!-- <nav class="navbar">
        <div class="container navbar-content">

            <div class="logo">
                <img src="assets/img/favicon.png" alt="GearGuard Logo">
            </div>
            <div class="nav-links">
                <a href="#home">Home</a>
                <a href="#about">About</a>
                <a href="#services">Services</a>
                <a href="#feedback">Feedback</a>
                <a href="#contact">Contact</a>
                <a href="/login">Login</a>
            </div>
            <button class="mobile-menu-btn">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </nav> -->

    <!-- Hero Section -->
    <section id="home" class="hero">
        <div class="carousel" id="carousel">
            <div class="carousel-slide active" style="background-image: url('https://images.unsplash.com/photo-1619642751034-765dfdf7c58e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1974&q=80')">
                <div class="hero-content fade-in">
                    <h1>Professional Vehicle Maintenance</h1>
                    <p>Comprehensive care for your vehicle, ensuring peak performance and longevity.</p>
                    <a href="#services" class="cta-button">Our Services</a>
                </div>
            </div>
            <div class="carousel-slide" style="background-image: url('https://www.indusmotor.com/public/uploads/pages/179020210129170225.jpg')">
                <div class="hero-content fade-in">
                    <h1>Advanced Diagnostic Services</h1>
                    <p>Cutting-edge technology to identify and resolve vehicle issues before they become problems.</p>
                    <a href="#services" class="cta-button">Learn More</a>
                </div>
            </div>
            <div class="carousel-slide" style="background-image: url('https://www.shutterstock.com/image-photo/hand-mechanic-holding-car-service-600nw-2340377479.jpg')">
                <div class="hero-content fade-in">
                    <h1>Expert Maintenance Team</h1>
                    <p>Certified technicians with years of experience dedicated to keeping your vehicle in top condition.</p>
                    <a href="/login" class="cta-button">Book Appointment</a>
                </div>
            </div>
        </div>

        <div class="carousel-controls">
            <div class="carousel-dot active" data-slide="0"></div>
            <div class="carousel-dot" data-slide="1"></div>
            <div class="carousel-dot" data-slide="2"></div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="section container">
        <h2 class="section-title">Why Choose GearGuard</h2>
        <div class="services-grid">
            <div class="service-card slide-in">
                <img src="/api/placeholder/100/100" alt="Expertise Icon">
                <h3>Certified Expertise</h3>
                <p>Our technicians are ASE-certified with extensive training and years of hands-on experience.</p>
            </div>
            <div class="service-card slide-in">
                <img src="/api/placeholder/100/100" alt="Technology Icon">
                <h3>Advanced Technology</h3>
                <p>We use state-of-the-art diagnostic tools to provide precise and efficient vehicle maintenance.</p>
            </div>
            <div class="service-card slide-in">
                <img src="/api/placeholder/100/100" alt="Transparency Icon">
                <h3>Transparent Service</h3>
                <p>Clear communication and honest recommendations are at the core of our service philosophy.</p>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="section container">
        <h2 class="section-title">Our Services</h2>
        <div class="services-grid">
            <div class="service-card slide-in">
                <img src="public/assets/img/profile.jpg" alt="Diagnostics Icon">
                <h3>Vehicle Diagnostics</h3>
                <p>Comprehensive system checks using advanced computerized diagnostic equipment.</p>
            </div>
            <div class="service-card slide-in">
                <img src="/api/placeholder/100/100" alt="Maintenance Icon">
                <h3>Routine Maintenance</h3>
                <p>Regular service to keep your vehicle running smoothly and prevent potential issues.</p>
            </div>
            <div class="service-card slide-in">
                <img src="/api/placeholder/100/100" alt="Repair Icon">
                <h3>Repair Services</h3>
                <p>Expert repairs for all major and minor vehicle systems and components.</p>
            </div>
            <div class="service-card slide-in">
                <img src="/api/placeholder/100/100" alt="Tire Service Icon">
                <h3>Tire Services</h3>
                <p>Tire rotation, alignment, balancing, and replacement services.</p>
            </div>
        </div>
    </section>

    <!-- Customer Feedback Section -->
    <section id="feedback" class="section container">
        <h2 class="section-title">What Our Customers Say</h2>
        <div class="feedback-grid">
            <div class="feedback-card slide-in">
                <img src="/api/placeholder/100/100" alt="Customer 1">
                <p>"GearGuard saved me from a major engine problem. Their diagnostics are top-notch!"</p>
                <h4>- Sarah Mitchell</h4>
            </div>
            <div class="feedback-card slide-in">
                <img src="/api/placeholder/100/100" alt="Customer 2">
                <p>"Professional, reliable, and always transparent. My go-to maintenance service."</p>
                <h4>- Michael Rodriguez</h4>
            </div>
            <div class="feedback-card slide-in">
                <img src="/api/placeholder/100/100" alt="Customer 3">
                <p>"Affordable pricing and exceptional service. Highly recommended!"</p>
                <h4>- Emily Chen</h4>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="section container">
        <h2 class="section-title">Contact Us</h2>
        <div class="contact-grid">
            <div class="contact-form">
                <h3>Send us a Message</h3>
                <form>
                    <input type="text" placeholder="Your Name" required>
                    <input type="email" placeholder="Your Email" required>
                    <input type="tel" placeholder="Your Phone Number">
                    <textarea placeholder="Your Message" rows="5" required></textarea>
                    <button type="submit" class="cta-button">Send Message</button>
                </form>
            </div>
            <div class="contact-details">
                <h3>Contact Information</h3>
                <p>Feel free to reach out to us through any of the following methods:</p>
                <h4>Phone</h4>
                <p>(+94) 71-234-6789</p>
                <h4>Email</h4>
                <p>support@gearguard.lk</p>
                <h4>Address</h4>
                <p>123 GearGuard, GearGuard City, Colombo 07</p>
                <div class="social-links">
                    <a href="#" target="_blank"><i class="fab fa-facebook"></i></a>
                    <a href="#" target="_blank"><i class="fab fa-twitter"></i></a>
                    <a href="#" target="_blank"><i class="fab fa-instagram"></i></a>
                    <a href="#" target="_blank"><i class="fab fa-linkedin"></i></a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->

    <div class="container">
        <p>&copy; 2024 GearGuard. All Rights Reserved.</p>
    </div>


    <script>
        // Mobile Menu Toggle
        const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
        const navLinks = document.querySelector('.nav-links');

        mobileMenuBtn.addEventListener('click', () => {
            navLinks.classList.toggle('active');
        });

        // Carousel Functionality
        const carousel = document.getElementById('carousel');
        const carouselSlides = carousel.querySelectorAll('.carousel-slide');
        const carouselDots = document.querySelectorAll('.carousel-dot');
        let currentSlide = 0;

        function changeSlide(index) {
            carouselSlides.forEach(slide => slide.classList.remove('active'));
            carouselDots.forEach(dot => dot.classList.remove('active'));

            carouselSlides[index].classList.add('active');
            carouselDots[index].classList.add('active');
        }

        carouselDots.forEach(dot => {
            dot.addEventListener('click', () => {
                currentSlide = parseInt(dot.getAttribute('data-slide'));
                changeSlide(currentSlide);
            });
        });

        // Auto Slide
        setInterval(() => {
            currentSlide = (currentSlide + 1) % carouselSlides.length;
            changeSlide(currentSlide);
        }, 5000);
    </script>
</body>

</html>