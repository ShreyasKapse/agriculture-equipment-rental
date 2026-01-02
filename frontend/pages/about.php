<?php
require_once '../../backend/config/db.php';
require_once '../includes/header.php';
?>

<!-- About Hero -->
<div class="hero-section">
    <div class="container text-center">
        <h1 class="hero-title">About Us</h1>
        <p class="hero-subtitle">Connecting farmers with agricultural equipment</p>
    </div>
</div>

<!-- Project Overview -->
<section class="section bg-white">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <h2 class="section-title">Our Mission</h2>
                <p class="lead text-center mb-4">Making agricultural equipment accessible and affordable for every
                    farmer</p>

                <div class="material-card-flat p-4 mb-4">
                    <h4 class="text-primary-green mb-3">Problem Statement</h4>
                    <p>Agricultural equipment is expensive and inaccessible to small-scale farmers. Many farmers cannot
                        afford to purchase machinery like tractors, harvesters, or rotavators, while equipment owners
                        struggle to monetize their idle assets.</p>
                </div>

                <div class="material-card-flat p-4 mb-4">
                    <h4 class="text-primary-green mb-3">Our Solution</h4>
                    <p>The Agriculture Equipment Rental System (AERS) bridges this gap by providing a digital
                        marketplace where farmers can easily rent equipment and owners can earn income from their
                        machinery. Our platform ensures transparency, affordability, and reliability.</p>
                </div>

                <div class="material-card-flat p-4">
                    <h4 class="text-primary-green mb-3">Key Features</h4>
                    <ul class="list-unstyled">
                        <li class="mb-2">✅ Easy equipment browsing and booking</li>
                        <li class="mb-2">✅ Secure user authentication</li>
                        <li class="mb-2">✅ Owner approval system</li>
                        <li class="mb-2">✅ Admin monitoring and management</li>
                        <li class="mb-2">✅ Transparent pricing</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Technologies Used -->
<section class="section bg-light-gray">
    <div class="container">
        <h2 class="section-title">Technologies Used</h2>
        <p class="section-subtitle">Built with modern, reliable technologies</p>

        <div class="row g-3 justify-content-center">
            <div class="col-md-2 col-sm-4 col-6">
                <div class="material-card text-center p-3">
                    <div class="mb-2" style="font-size: 2.5rem;">🌐</div>
                    <h6>HTML5</h6>
                </div>
            </div>
            <div class="col-md-2 col-sm-4 col-6">
                <div class="material-card text-center p-3">
                    <div class="mb-2" style="font-size: 2.5rem;">🎨</div>
                    <h6>CSS3</h6>
                </div>
            </div>
            <div class="col-md-2 col-sm-4 col-6">
                <div class="material-card text-center p-3">
                    <div class="mb-2" style="font-size: 2.5rem;">📱</div>
                    <h6>Bootstrap 5</h6>
                </div>
            </div>
            <div class="col-md-2 col-sm-4 col-6">
                <div class="material-card text-center p-3">
                    <div class="mb-2" style="font-size: 2.5rem;">⚡</div>
                    <h6>JavaScript</h6>
                </div>
            </div>
            <div class="col-md-2 col-sm-4 col-6">
                <div class="material-card text-center p-3">
                    <div class="mb-2" style="font-size: 2.5rem;">🐘</div>
                    <h6>PHP</h6>
                </div>
            </div>
            <div class="col-md-2 col-sm-4 col-6">
                <div class="material-card text-center p-3">
                    <div class="mb-2" style="font-size: 2.5rem;">🗄️</div>
                    <h6>MySQL</h6>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Team Section -->
<section class="section bg-white">
    <div class="container">
        <h2 class="section-title">Our Team</h2>
        <p class="section-subtitle">Meet the developers behind this project</p>

        <div class="row g-4 justify-content-center">
            <div class="col-md-3 col-sm-6">
                <div class="material-card text-center p-4">
                    <div class="mb-3">
                        <img src="../assets/images/samiksha.jpeg" alt="Samiksha Sachin Salunke"
                            style="width: 120px; height: 120px; border-radius: 50%; margin: 0 auto; display: block; object-fit: cover; border: 4px solid #fff; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
                    </div>
                    <h5 class="mb-1">Samiksha Sachin Salunke</h5>
                    <p class="text-muted mb-2">Full Stack Developer</p>
                    <p class="small text-secondary">Diploma in Computer Engineering<br>samikshasalunke1@gmail.com</p>
                </div>
            </div>

            <div class="col-md-3 col-sm-6">
                <div class="material-card text-center p-4">
                    <div class="mb-3">
                        <img src="../assets/images/prachi.jpeg" alt="Prachi Mohan Deokate"
                            style="width: 120px; height: 120px; border-radius: 50%; margin: 0 auto; display: block; object-fit: cover; border: 4px solid #fff; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
                    </div>
                    <h5 class="mb-1">Prachi Mohan Deokate</h5>
                    <p class="text-muted mb-2">Backend Developer</p>
                    <p class="small text-secondary">Diploma in Computer Engineering<br>prachi48@gmail.com</p>
                </div>
            </div>

            <div class="col-md-3 col-sm-6">
                <div class="material-card text-center p-4">
                    <div class="mb-3">
                        <img src="../assets/images/rinku.jpeg" alt="Rinku Babasaheb Aade"
                            style="width: 120px; height: 120px; border-radius: 50%; margin: 0 auto; display: block; object-fit: cover; border: 4px solid #fff; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
                    </div>
                    <h5 class="mb-1">Rinku Babasaheb Aade</h5>
                    <p class="text-muted mb-2">Frontend Developer</p>
                    <p class="small text-secondary">Diploma in Computer Engineering<br>rinkuade5257@gmail.com</p>
                </div>
            </div>

            <div class="col-md-3 col-sm-6">
                <div class="material-card text-center p-4">
                    <div class="mb-3">
                        <img src="../assets/images/hridhima.jpeg" alt="Hridhima Deepak Gadekar"
                            style="width: 120px; height: 120px; border-radius: 50%; margin: 0 auto; display: block; object-fit: cover; border: 4px solid #fff; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
                    </div>
                    <h5 class="mb-1">Hridhima Deepak Gadekar</h5>
                    <p class="text-muted mb-2">Database Designer</p>
                    <p class="small text-secondary">Diploma in Computer Engineering<br>hridhima.gadekar@gmail.com</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Guide/Mentor Section -->
<section class="section bg-light-gray">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="material-card p-4 text-center">
                    <h4 class="mb-3">Project Guide</h4>
                    <div class="mb-3">
                        <div
                            style="width: 100px; height: 100px; background: var(--primary-green); border-radius: 50%; margin: 0 auto; display: flex; align-items: center; justify-content: center; font-size: 2.5rem; color: white;">
                            👨‍🏫
                        </div>
                    </div>
                    <h5 class="mb-1">[Guide Name]</h5>
                    <p class="text-muted mb-2">[Designation]</p>
                    <p class="small text-secondary">[Department]<br>[Your College Name]</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Project Info -->
<section class="section bg-white">
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto text-center">
                <div class="material-card-flat p-4">
                    <h5 class="mb-3">Academic Project</h5>
                    <p class="mb-2"><strong>Academic Year:</strong> 2024-2025</p>
                    <p class="mb-2"><strong>Program:</strong> Diploma in Computer Engineering</p>
                    <p class="mb-0"><strong>Institution:</strong> [Your Institute Name]</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once '../includes/footer.php'; ?>