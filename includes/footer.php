<footer class="isaro-footer pt-5" style="background-color: #2b2b2b; color: #ffffff;">
    <style>
        /* Placeholder styling */
        .isaro-subscribe-input::placeholder {
            color: #cccccc !important;
            opacity: 1 !important;
        }

        /* Global Smooth Transition for Links & Icons */
        .isaro-footer a, 
        .isaro-footer i, 
        .isaro-footer button {
            transition: all 0.3s ease !important;
        }

        /* Quick Links & Contact Website Red Hover */
        .isaro-footer a.text-white-50:hover,
        .isaro-footer-link:hover {
            color: #c82333 !important;
            padding-left: 3px;
        }

        /* Social Media Icons Red Hover & Lift Effect */
        .isaro-social-icon {
            color: #ffffff !important;
            display: inline-block;
        }
        .isaro-social-icon:hover {
            color: #c82333 !important;
            transform: translateY(-3px);
        }

        /* Subscribe Send Button Red Hover */
        .isaro-sub-btn:hover i {
            color: #c82333 !important;
            transform: scale(1.15) rotate(-10deg);
        }

        /* App Store & Play Store Badges Red Border Hover */
        .isaro-app-badge:hover {
            border-color: #c82333 !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(200, 35, 51, 0.3) !important;
        }
    </style>

    <div class="container pb-4">
        <div class="row g-4 justify-content-between align-items-start">
            
            <!-- Col 1: Logo & Subscribe -->
            <div class="col-12 col-md-6 col-lg-3">
                <div class="bg-white p-2 rounded-2 mb-4 d-inline-block" style="max-width: 200px;">
                    <img src="assets/images/industrial_automation_logo 1.png" alt="Isaro Automation" class="img-fluid">
                </div>
                <h5 class="text-white fw-medium mb-3 fs-5">Subscribe</h5>
                <form action="#" method="POST">
                    <div class="position-relative" style="max-width: 230px;">
                        <input type="email" name="subscribe_email" class="form-control bg-transparent text-white rounded-1 py-2 pe-5 isaro-subscribe-input" placeholder="Enter your email" required style="font-size: 0.82rem; border: 1px solid #777;">
                        <button class="btn border-0 text-white position-absolute end-0 top-50 translate-middle-y px-3 isaro-sub-btn" type="submit" style="background: transparent;">
                            <i class="far fa-paper-plane" style="font-size: 1rem;"></i>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Col 2: Contact Info -->
            <div class="col-12 col-md-6 col-lg-3">
                <div class="d-flex mb-3">
                    <i class="fas fa-map-marker-alt text-white fs-5 me-3 mt-1"></i>
                    <div class="text-white-50" style="line-height: 1.5; font-size: 0.85rem;">
                        <span class="text-white fw-medium">Isaro Automation Systems (Pvt) Ltd</span><br>
                        No. 400,Galle Road<br>
                        Rawathawatte, Moratuwa<br>
                        Sri Lanka
                    </div>
                </div>
                <div class="d-flex align-items-center mb-3">
                    <i class="far fa-envelope text-white fs-5 me-3"></i>
                    <a href="https://www.isaroautomation.com" target="_blank" class="text-white-50 text-decoration-none isaro-footer-link" style="font-size: 0.85rem;">www.isaroautomation.com</a>
                </div>
                <div class="d-flex align-items-start">
                    <i class="fas fa-phone-alt text-white fs-5 me-3 mt-1" style="transform: scaleX(-1);"></i>
                    <div class="text-white-50" style="font-size: 0.85rem; line-height: 1.5;">
                        <a href="tel:+94114011784" class="text-white-50 text-decoration-none">+ 94 11 4011784</a><br>
                        <a href="tel:+94114216784" class="text-white-50 text-decoration-none">+ 94 11 4216784</a>
                    </div>
                </div>
            </div>

            <!-- Col 3: Quick Links -->
            <div class="col-12 col-md-6 col-lg-2">
                <h5 class="text-white fw-medium mb-3 fs-5">Quick Link</h5>
                <ul class="list-unstyled mb-0 d-flex flex-column gap-2" style="font-size: 0.88rem;">
                    <li><a href="#" class="text-white-50 text-decoration-none isaro-footer-link">Privacy Policy</a></li>
                    <li><a href="#" class="text-white-50 text-decoration-none isaro-footer-link">Terms Of Use</a></li>
                    <li><a href="faq.php" class="text-white-50 text-decoration-none isaro-footer-link">FAQ</a></li>
                    <li><a href="contact.php" class="text-white-50 text-decoration-none isaro-footer-link">Contact</a></li>
                </ul>
            </div>

            <!-- Col 4: App & Social -->
            <div class="col-12 col-md-6 col-lg-3">
                <h5 class="text-white fw-medium mb-1 fs-5">Download App</h5>
                <p class="text-white-50 mb-3" style="font-size: 0.72rem;">Save $3 with App New User Only</p>
                
                <div class="d-flex align-items-center gap-2 mb-3">
                    <!-- QR Code -->
                    <div class="bg-white p-1 rounded-2">
                        <img src="assets/images/Qr Code.png" alt="QR Code" class="img-fluid" style="width: 72px; height: 72px; object-fit: contain;">
                    </div>
                    
                    <!-- Store Badges -->
                    <div class="d-flex flex-column gap-1">
                        <a href="#" class="btn btn-dark btn-sm py-1 px-2 border border-secondary rounded-2 d-flex align-items-center gap-2 text-decoration-none isaro-app-badge" style="background-color: #000; width: 125px;">
                            <i class="fab fa-google-play fs-6 text-white"></i>
                            <div class="text-start lh-1">
                                <span style="font-size: 0.5rem; display: block;" class="text-uppercase text-white-50">GET IT ON</span>
                                <span class="fw-bold text-white" style="font-size: 0.72rem;">Google Play</span>
                            </div>
                        </a>
                        <a href="#" class="btn btn-dark btn-sm py-1 px-2 border border-secondary rounded-2 d-flex align-items-center gap-2 text-decoration-none isaro-app-badge" style="background-color: #000; width: 125px;">
                            <i class="fab fa-apple fs-5 text-white"></i>
                            <div class="text-start lh-1">
                                <span style="font-size: 0.48rem; display: block;" class="text-uppercase text-white-50">Download on the</span>
                                <span class="fw-bold text-white" style="font-size: 0.72rem;">App Store</span>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Social Icons Row -->
                <div class="d-flex gap-4 text-white fs-5 pt-1">
                    <a href="#" class="isaro-social-icon"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="isaro-social-icon"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="isaro-social-icon"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="isaro-social-icon"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>

        </div>
    </div>

    <!-- Thin Red Line Above Copyright -->
    <div class="container">
        <hr style="border-color: #b03030; opacity: 0.8; margin: 0;">
    </div>

    <!-- Bottom Copyright -->
    <div class="py-3 text-center text-white-50" style="font-size: 0.8rem;">
        <div class="container">
            <p class="mb-0">&copy; <?php echo date('Y'); ?> SLT Digital. All rights reserved.</p>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>