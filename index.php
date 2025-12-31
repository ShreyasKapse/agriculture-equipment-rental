<?php
require_once 'backend/config/db.php';
require_once 'frontend/includes/header.php';
?>

<style>
    .hero-section {
        background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)),
            url('/agriculture-equipment-rental/frontend/assets/images/hero-tractor.png');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        color: white;
        padding: 8rem 0 6rem;
        margin-top: -56px;
        padding-top: calc(8rem + 56px);
        position: relative;
    }

    .how-it-works-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #E8F5E9, #C8E6C9);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        box-shadow: 0 4px 12px rgba(46, 125, 50, 0.2);
    }

    .how-it-works-icon svg {
        width: 40px;
        height: 40px;
        fill: #2E7D32;
    }

    .category-card-img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-radius: 12px 12px 0 0;
    }

    .category-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        cursor: pointer;
        border: 2px solid transparent;
    }

    .category-card:hover {
        box-shadow: 0 8px 24px rgba(46, 125, 50, 0.2);
        transform: translateY(-8px);
        border-color: #2E7D32;
    }

    .category-card-content {
        padding: 1.5rem;
        text-align: center;
    }

    .category-card h4 {
        margin: 0 0 0.5rem 0;
        color: #212121;
        font-weight: 700;
    }

    .why-choose-icon {
        width: 70px;
        height: 70px;
        background: linear-gradient(135deg, #2E7D32, #66BB6A);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        box-shadow: 0 4px 12px rgba(46, 125, 50, 0.3);
    }

    .why-choose-icon svg {
        width: 35px;
        height: 35px;
        fill: white;
    }
</style>

<!-- Hero Section -->
<div class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="hero-title" style="font-size: 3.5rem;">Rent Agricultural Equipment Easily</h1>
                <p class="hero-subtitle" style="font-size: 1.3rem;">Connecting farmers with the machinery they need to
                    grow effectively and affordably. Join our community today.</p>
                <div class="mt-4">
                    <a href="/agriculture-equipment-rental/frontend/pages/farmer/browse_equipment.php"
                        class="btn btn-light btn-lg me-3 mb-2">
                        View Equipment
                    </a>
                    <a href="/agriculture-equipment-rental/frontend/pages/auth/register.php"
                        class="btn btn-outline-light btn-lg mb-2">
                        Register as Owner
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- How It Works Section -->
<section class="section bg-white">
    <div class="container">
        <h2 class="section-title">How it Works</h2>
        <p class="section-subtitle">Get started with AERS in three simple steps</p>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="step-card">
                    <div class="how-it-works-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path
                                d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z" />
                        </svg>
                    </div>
                    <h3 class="feature-title">Browse & Search</h3>
                    <p class="feature-description">Find the right equipment for your farm. Filter by type, price, and
                        location to get exactly what you need.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="step-card">
                    <div class="how-it-works-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path
                                d="M17 12h-5v5h5v-5zM16 1v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2h-1V1h-2zm3 18H5V8h14v11z" />
                        </svg>
                    </div>
                    <h3 class="feature-title">Book Securely</h3>
                    <p class="feature-description">Simple booking process with verified equipment owners. Search, book,
                        and pay securely through our platform.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="step-card">
                    <div class="how-it-works-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path
                                d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" />
                        </svg>
                    </div>
                    <h3 class="feature-title">Farm & Return</h3>
                    <p class="feature-description">Use the machinery to improve your yield and return it easily. Enjoy
                        transparent pricing and flexible rental periods.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Equipment Categories -->
<section class="section bg-light-gray">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="section-title" style="text-align: left; margin-bottom: 0;">Equipment Categories</h2>
                <p class="section-subtitle" style="text-align: left; margin-bottom: 0;">Browse equipment by category</p>
            </div>
            <a href="/agriculture-equipment-rental/frontend/pages/farmer/browse_equipment.php"
                class="btn btn-primary">View All</a>
        </div>

        <div class="row g-4">
            <div class="col-md-3 col-sm-6">
                <div class="category-card">
                    <img src="/agriculture-equipment-rental/frontend/assets/images/tractor-category.png" alt="Tractors"
                        class="category-card-img">
                    <div class="category-card-content">
                        <h4>Tractors</h4>
                        <p class="text-muted mb-0">Heavy-duty farming</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="category-card">
                    <img src="/agriculture-equipment-rental/frontend/assets/images/harvester-category.png"
                        alt="Harvesters" class="category-card-img">
                    <div class="category-card-content">
                        <h4>Harvesters</h4>
                        <p class="text-muted mb-0">Efficient crop cutting</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="category-card">
                    <img src="/agriculture-equipment-rental/frontend/assets/images/plough-category.png" alt="Ploughs"
                        class="category-card-img">
                    <div class="category-card-content">
                        <h4>Ploughs</h4>
                        <p class="text-muted mb-0">Soil preparation tools</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="category-card">
                    <img src="/agriculture-equipment-rental/frontend/assets/images/seeder-category.png" alt="Seeders"
                        class="category-card-img">
                    <div class="category-card-content">
                        <h4>Seeders</h4>
                        <p class="text-muted mb-0">Precision planting</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Why Choose AERS -->
<section class="section bg-white">
    <div class="container">
        <h2 class="section-title">Why Choose AERS?</h2>
        <p class="section-subtitle">We are dedicated to supporting the agricultural community by making machinery
            accessible to everyone</p>

        <div class="row g-4">
            <div class="col-md-3 col-sm-6">
                <div class="feature-card">
                    <div class="why-choose-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path
                                d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z" />
                        </svg>
                    </div>
                    <h4 class="feature-title">Affordable Daily Rates</h4>
                    <p class="feature-description">Competitive pricing that fits your farm's budget</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="feature-card">
                    <div class="why-choose-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path
                                d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm-2 16l-4-4 1.41-1.41L10 14.17l6.59-6.59L18 9l-8 8z" />
                        </svg>
                    </div>
                    <h4 class="feature-title">Verified Equipment Quality</h4>
                    <p class="feature-description">All machinery is inspected and maintained regularly</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="feature-card">
                    <div class="why-choose-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path
                                d="M20 2H4c-1.1 0-1.99.9-1.99 2L2 22l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zM6 9h12v2H6V9zm8 5H6v-2h8v2zm4-6H6V6h12v2z" />
                        </svg>
                    </div>
                    <h4 class="feature-title">24/7 Support</h4>
                    <p class="feature-description">We're always available to assist with any booking or issues</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="feature-card">
                    <div class="why-choose-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path
                                d="M19 3h-4.18C14.4 1.84 13.3 1 12 1c-1.3 0-2.4.84-2.82 2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 0c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zm2 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z" />
                        </svg>
                    </div>
                    <h4 class="feature-title">Transparent Pricing</h4>
                    <p class="feature-description">No hidden fees, clear rental terms and conditions</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="section" style="background: linear-gradient(135deg, #2E7D32 0%, #66BB6A 100%); color: white;">
    <div class="container text-center">
        <h2 class="display-4 fw-bold mb-3">Ready to Boost Your Harvest?</h2>
        <p class="lead mb-4">Join thousands of farmers using AERS to access the best equipment for their land</p>
        <a href="/agriculture-equipment-rental/frontend/pages/auth/register.php" class="btn btn-light btn-lg">
            Start Renting Today
        </a>
    </div>
</section>

<?php require_once 'frontend/includes/footer.php'; ?>