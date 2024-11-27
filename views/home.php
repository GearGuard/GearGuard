<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GearGuard - Professional Vehicle Maintenance</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --text: #f5f5f5;
            --background: #181a20;
            --primary: #C0C0C0FF;
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
            font-family: "Inter", sans-serif;
            background-color: var(--background);
            color: var(--text);
            line-height: 1.6;
            overflow-x: hidden;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }

        /* Navigation */
        .navbar {
            background-color: var(--secondary);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
            transition: background-color 0.3s ease;
        }

        .navbar-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 0;
        }

        .logo {
            font-size: 1.5rem;
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
            position: relative;
            height: 100vh;
            display: flex;
            align-items: center;
            overflow: hidden;
        }

        /* Carousel Styles */
        .carousel {
            display: flex;
            transition: transform 0.5s ease;
            transform: translateX(0);
            width: 300%;
            /* Assuming 3 slides, adjust if more slides are added */
        }

        .carousel-slide {
            flex: 1 0 100%;
            /* Each slide takes 100% of the viewport */
            height: 100%;
            background-size: cover;
            background-position: center;
        }


        .carousel-slide.active {
            opacity: 1;
        }

        .hero-content {
            background-color: rgba(0, 0, 0, 0.6);
            padding: 2rem;
            border-radius: 12px;
            max-width: 600px;
            transform: translateY(20px);
            opacity: 0;
            transition: transform 0.5s ease, opacity 0.5s ease;
        }

        .carousel-slide.active .hero-content {
            transform: translateY(0);
            opacity: 1;
        }

        .hero-content h1 {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: var(--accent);
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
        }

        .cta-button:hover {
            background-color: #1b4ebd;
            transform: translateY(-2px);
        }

        /* Section Styles */
        .section {
            padding: 4rem 0;
            background-color: var(--secondary);
        }

        .section-title {
            text-align: center;
            margin-bottom: 3rem;
            color: var(--primary);
            position: relative;
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

        /* About Us */
        .about-content {
            display: flex;
            align-items: center;
            gap: 2rem;
        }

        .about-image {
            flex: 1;
            perspective: 1000px;
        }

        .about-image img {
            max-width: 100%;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
            transition: transform 0.3s ease;
        }

        .about-image img:hover {
            transform: rotateY(10deg);
        }

        .about-text {
            flex: 1;
        }

        /* Services */
        .services-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
        }

        .service-card {
            background-color: var(--background);
            padding: 2rem;
            border-radius: 12px;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: 1px solid var(--border);
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

        /* Customer Feedback */
        .feedback-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
        }

        .feedback-card {
            background-color: var(--background);
            padding: 2rem;
            border-radius: 12px;
            text-align: center;
            border: 1px solid var(--border);
            transition: transform 0.3s ease;
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

        /* Contact Form */
        .contact-form {
            max-width: 600px;
            margin: 0 auto;
            background-color: var(--secondary);
            padding-top: 2rem;
            border-radius: 12px;
        }

        .contact-form input,
        .contact-form textarea {
            width: 100%;
            padding: 0.75rem;
            margin-bottom: 1rem;
            background-color: var(--background);
            border: 1px solid var(--border);
            border-radius: 8px;
            color: var(--text);
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
            width: 10px;
            height: 10px;
            background-color: rgba(255, 255, 255, 0.5);
            border-radius: 50%;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .carousel-dot.active {
            background-color: var(--accent);
        }

        .contact-me {
            color: var(--accent);
            padding-bottom: 1rem;
            font-size: 1.5rem;

        }

        /* Contact Us Section */
        .contact-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            align-items: center;
            justify-content: center;
        }

        .contact-details {
            background-color: var(--background);
            margin-left: 2rem;
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



        .footer-about {
            color: var(--primary);

        }

        /* Responsive Design */
        @media (max-width: 768px) {

            .about-content,
            .services-grid,
            .feedback-grid {
                grid-template-columns: 1fr;
            }

            .hero-content h1 {
                font-size: 2rem;
            }

            .nav-links {
                display: none;
                /* For simplicity. In a real site, you'd add a mobile menu */
            }
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="container navbar-content">
            <div class="logo">GearGuard</div>
            <div class="nav-links">
                <a href="#home">Home</a>
                <a href="#about">About</a>
                <a href="#services">Services</a>
                <a href="#feedback">Feedback</a>
                <a href="#contact">Contact</a>
                <a href="#login">Login</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="hero">
        <div class="carousel" id="carousel">
            <div class="carousel-slide active" style="background-image: url('https://www.independent.lk/wp-content/uploads/questions-about-electric-car-768x432-1.jpg')">
                <div class="hero-content">
                    <h1>Professional Vehicle Maintenance</h1>
                    <p>Comprehensive care for your vehicle, ensuring peak performance and longevity.</p>
                    <a href="#services" class="cta-button">Our Services</a>
                </div>
            </div>
            <div class="carousel-slide" style="background-image: url('https://www.independent.lk/wp-content/uploads/questions-about-electric-car-768x432-1.jpg')">
                <div class="hero-content">
                    <h1>Expert Technicians</h1>
                    <p>Skilled professionals using cutting-edge diagnostic tools and techniques.</p>
                    <a href="#services" class="cta-button">Our Services</a>
                </div>
            </div>
            <div class="carousel-slide" style="background-image: url('https://www.independent.lk/wp-content/uploads/questions-about-electric-car-768x432-1.jpg')">
                <div class="hero-content">
                    <h1>Convenient Booking</h1>
                    <p>Easy online scheduling and transparent service tracking.</p>
                    <a href="#services" class="cta-button">Our Services</a>
                </div>
            </div>
        </div>
        <div class="carousel-controls" id="carouselControls">
            <div class="carousel-dot active" data-slide="0"></div>
            <div class="carousel-dot" data-slide="1"></div>
            <div class="carousel-dot" data-slide="2"></div>
        </div>
    </section>


    <!-- Our Services -->
    <section id="services" class="section container">
        <h2 class="section-title">Our Services</h2>
        <div class="services-grid">
            <div class="service-card">
                <img src="https://cdn-icons-png.flaticon.com/128/3097/3097844.png" alt="Repair">
                <h3>Vehicle Repair</h3>
                <p>Comprehensive repair services for all vehicle types and models.</p>
            </div>
            <div class="service-card">
                <img src="https://cdn-icons-png.flaticon.com/128/3369/3369914.png" alt="Maintenance">
                <h3>Regular Maintenance</h3>
                <p>Scheduled maintenance to keep your vehicle in optimal condition.</p>
            </div>
            <div class="service-card">
                <img src="https://cdn-icons-png.flaticon.com/128/6863/6863560.png" alt="Diagnostics">
                <h3>Diagnostic Services</h3>
                <p>Advanced diagnostic tools to quickly identify and resolve issues.</p>
            </div>
        </div>
    </section>

    <section id="feedback" class="section container">
        <h2 class="section-title">Customer Feedback</h2>
        <div class="feedback-grid">
            <div class="feedback-card">
                <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?q=80&w=1887&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Customer 1">
                <p>"Exceptional service! They diagnosed and fixed my car's issue quickly and professionally."</p>
                <h4>- John Doe</h4>
            </div>
            <div class="feedback-card">
                <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?q=80&w=1887&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Customer 2">
                <p>"Always reliable and transparent. I trust them completely with my vehicle."</p>
                <h4>- Jane Smith</h4>
            </div>
            <div class="feedback-card">
                <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?q=80&w=1887&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Customer 3">
                <p>"Convenient online booking and top-notch customer service. Highly recommended!"</p>
                <h4>- Mike Johnson</h4>
            </div>
        </div>
    </section>

    <!-- Contact Us Section -->
    <section id="contact" class="section container">
        <h2 class="section-title">Get in Touch</h2>
        <p style="text-align: center; margin-bottom: 2rem; color: var(--primary);">
            Have questions or need assistance? We'd love to hear from you. Fill out the form below or reach out using the contact details.
        </p>
        <div class="contact-grid">
            <!-- Contact Details -->
            <div class="contact-details">
                <h3 class="contact-me">Contact Information</h3>
                <p><strong>Address:</strong> 123 Main Street, Anytown, USA</p>
                <p><strong>Phone:</strong> <a href="tel:+1234567890" style="color: var(--accent); text-decoration: none;">+1 234 567 890</a></p>
                <p><strong>Email:</strong> <a href="mailto:support@GearGuard.com" style="color: var(--accent); text-decoration: none;">support@GearGuard.com</a></p>
                <h4>Follow Us:</h4>
                <div style="
                    display: flex; 
                    gap: 10px; 
                    margin-top: 1rem; 
                    align-items: center; 
                    justify-content: center;">
                    <a href="#" style="color: var(--accent); font-size: 1.5rem;"><i class="fab fa-facebook"></i></a>
                    <a href="#" style="color: var(--accent); font-size: 1.5rem;"><i class="fab fa-twitter"></i></a>
                    <a href="#" style="color: var(--accent); font-size: 1.5rem;"><i class="fab fa-instagram"></i></a>
                    <a href="#" style="color: var(--accent); font-size: 1.5rem;"><i class="fab fa-linkedin"></i></a>
                </div>

            </div>
            <!-- Contact Form -->
            <form class="contact-form">
                <input type="text" placeholder="Your Full Name" required>
                <input type="email" placeholder="Your Email Address" required>
                <input type="tel" placeholder="Your Phone Number" required>
                <textarea placeholder="Your Message" rows="5" required></textarea>
                <button type="submit" class="cta-button">Submit Message</button>
            </form>
        </div>
    </section>

    <!-- Footer -->
    <section>
        <div>
            <p style="color:var(--primary)">&copy; 2024 GearGuard. All Rights Reserved.</p>
        </div>
    </section>



    <script>
        // Carousel Functionality
        const carousel = document.getElementById('carousel');
        const carouselControls = document.getElementById('carouselControls');
        const slides = carousel.querySelectorAll('.carousel-slide');
        const dots = carouselControls.querySelectorAll('.carousel-dot');
        let currentSlide = 0;

        function showSlide(index) {
            // Ensure index is within bounds
            index = (index + slides.length) % slides.length;

            // Hide all slides and remove active class from dots
            slides.forEach(slide => slide.classList.remove('active'));
            dots.forEach(dot => dot.classList.remove('active'));

            // Show the selected slide and add active class to corresponding dot
            slides[index].classList.add('active');
            dots[index].classList.add('active');

            // Update current slide index
            currentSlide = index;
        }

        function nextSlide() {
            showSlide(currentSlide + 1);
        }

        // Add click event to dots
        dots.forEach((dot, index) => {
            dot.addEventListener('click', () => {
                showSlide(index);
            });
        });

        // Auto-slide every 5 seconds
        const autoSlideInterval = setInterval(nextSlide, 5000);
    </script>

</body>

</html>