<?php
session_start(); // Toujours démarrer la session en haut de la page
?>
<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom    = $_POST['nom'];
    $email  = $_POST['email'];
    $objet  = $_POST['objet'];
    $message= $_POST['message'];

    $mail = new PHPMailer(true);

    try {
        // Config SMTP
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'salmadahmane2005@gmail.com'; // ton email Gmail
        $mail->Password   = 'qevc mufc hamq bpoc'; // mot de passe d'application
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Destinataires
        $mail->setFrom($email, $nom);
        $mail->addAddress('salmadahmane970@gmail.com'); // destinataire

        // Contenu
        $mail->isHTML(true);
        $mail->Subject = $objet;
        $mail->Body    = "<h3>Nom : $nom</h3>
                          <h3>Email : $email</h3>
                          <p>Message : $message</p>";

        if ($mail->send()) {
    echo '<script>
        document.addEventListener("DOMContentLoaded", function() {
            var myModal = new bootstrap.Modal(document.getElementById("successModal"));
            myModal.show();
        });
    </script>';
} else {
    echo '<script>
        alert("Erreur lors de l\'envoi : ' . $mail->ErrorInfo . '");
    </script>';
}

    } catch (Exception $e) {
    echo '<script>
        document.addEventListener("DOMContentLoaded", function() {
            var myModal = new bootstrap.Modal(document.getElementById("errorModal"));
            myModal.show();
        });
    </script>';
    }
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact | Elite Machinery</title>
    <!-- Bootstrap CSS -->
    <link href="assets/CSS/bootstrap.min.css" rel="stylesheet">
    <!-- AOS CSS -->
    <link href="assets/CSS/aos.css" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800;900&display=4wap">
    <link rel="stylesheet" href="assets/CSS/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/CSS/owl.theme.default.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/CSS/style.css">
    <link rel="stylesheet" href="assets/CSS/contact-style.css">
    <!--  mais links  -->
    <script src="authbutton.js"></script>

    

</head>
<body>
    <header id="header-area" class="header-area">
        <div class="top-header py-2">
            <div class="container-fluid">
                
                <div class="row ">
                    <div class="col-12">
                        <div class="header-area-content d-flex justify-content-between">
                            
                            <div class="pt-2">
                                <a href="#" class="text-decoration-none text-light anchor d-sm-inline d-none">
                                    <span><i class="fas fa-phone-volume"></i></span>
                                    <span class="hide-sm">+ 0523353914</span>
                                </a>
                                
                                <span class="border-right d-md-inline d-none"></span>
                                
                                <a href="#" class="text-decoration-none text-light anchor d-md-inline d-none">
                                    <span><i class="fas fa-map-marker-alt"></i></span>
                                    <span class="hide-sm">3 lot hasna jabrane, Av Khalil Jabran, El Jadida</span>
                                </a>
                            </div>
                            
                            <div class="d-flex align-items-center hide ">
                                <div>
                                    <a href="#" class="text-decoration-none text-light anchor d-lg-inline d-none">
                                        <span><i class="fa-regular fa-clock"></i></span>
                                        <span class="hide-sm">
                                            Du lundi au vendredi – de 08h30 à 18h00
                                        </span>
                                    </a>
                                   
                                    <span class="border-right d-lg-inline d-none"></span>
                                </div>
                                
                                <div class="social-icon d-flex">
                                    <div class="squre">
                                        <a href="https://www.facebook.com/profile.php?id=100076252924876" class="text-decoration-none">
                                            <i class="fab fa-facebook-f"></i>
                                        </a>
                                    </div>
                                    <div class="squre">
                                        <a href="https://www.facebook.com/profile.php?id=100076252924876" class="text-decoration-none">
                                            <i class="fa-brands fa-twitter"></i>
                                        </a>
                                    </div>
                                    <div class="squre">
                                        <a href="https://www.facebook.com/profile.php?id=100076252924876" class="text-decoration-none">
                                            <i class="fab fa-instagram"></i>
                                        </a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- End Header  -------- -->

<!-- Start NavBAr  -------- -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            
            <a class="navbar-brand text-light"  href="index.html">
                <h4  data-aos="fade-down">INOX INDUSTRIE</h4>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="fa-solid fa-bars">
                </span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="apropos.php">À propos</a>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="capabilities.html">Our Capabilities</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="industries.html">Industries</a>
                    </li> -->
                    <li class="nav-item">
                        <a class="nav-link" href="produits.php">Produits</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.php">Contact</a>
                    </li>

                </ul>
                
                      






                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0 d-flex gap-2">
             
                    
                <?php if (isset($_SESSION['user_id'])): ?>
                <a class="btn btn-outline-light" href="panier.php">
                  <i class="fa-solid fa-cart-shopping"></i>
                </a>
            <?php else: ?>
                 <a class="btn btn-outline-light" href="#" data-bs-toggle="modal" data-bs-target="#connectModal">
                     <i class="fa-solid fa-cart-shopping"></i>
                 </a>
            <?php endif; ?>

                
            

                <li class="nav-item">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <!-- Si connecté → bouton Déconnexion -->
                        <a class="btn btn-custom" href="logout.php">Se Déconnecter</a>
                    <?php else: ?>
                        <!-- Si non connecté → bouton Connexion -->
                        <a class="btn btn-custom" href="SignIn-SignUp-Form-main/login.php">Se Connecter</a>
                    <?php endif; ?>
                </li>
            </ul>



            
            </div>
        </div>
    </nav>
    <!-- End NavBAr  -------- -->

    <!-- Hero Section -->
    <section class="contact-hero" style="background: linear-gradient(#000000a8, #000000a8), url('assets/IMG/bg5.jpg');">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="hero-content text-center">
                        <h1 class="display-3 text-white mb-4" data-aos="fade-down">Restons en contact</h1>
                        <p class="lead text-light" data-aos="fade-up">L’équipe d’Inox Industrie est là pour vous accompagner</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact + Quote Section -->
    <section class="contact-quote-section py-5">
        <div class="container">
            <div class="row g-4">
                <!-- Contact Info Column -->
                <div class="col-lg-4" data-aos="fade-right">
                    <div class="contact-info-card p-4 h-100">
                        <h3 class="mb-4"><i class="fas fa-map-marker-alt me-2"></i> Notre adresse</h3>
                        <p class="mb-4">3 lot hasna jabrane, Av Khalil Jabran<br> El Jadida</p>
                        
                        <h3 class="mb-4"><i class="fas fa-phone-alt me-2"></i> Coordonnées</h3>
                        <p class="mb-2"><strong>Phone:</strong> 05 22 46 03 04</p>
                        <p class="mb-4"><strong>Email:</strong> contact@bowerindustrie.ma</p>
                        
                        <h3 class="mb-4"><i class="fas fa-clock me-2"></i> Nos horaires</h3>
                        <p class="mb-2"><strong>Du lundi au vendredi:</strong>  08h30-18h00</p>
                        <p><strong>Samedi:</strong>	08h00–12h30</p>
                        
                        <div class="social-icons mt-1">
                            <a href="https://www.facebook.com/profile.php?id=100076252924876" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                            <a href="https://www.linkedin.com/company/inoxindustrie/posts/?feedView=all" class="social-icon"><i class="fab fa-linkedin-in"></i></a>
                            <a href="https://www.facebook.com/profile.php?id=100076252924876" class="social-icon"><i class="fab fa-twitter"></i></a>
                            <a href="https://www.facebook.com/profile.php?id=100076252924876" class="social-icon"><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                </div>
                
                <!-- Combined Form Column -->
                <div class="col-lg-8" data-aos="fade-left">
                    <div class="form-tabs">
                        <ul class="nav nav-tabs" id="contactTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab">Contactez-nous</button>
                            </li>
                            <!-- <li class="nav-item" role="presentation">
                                <button class="nav-link" id="quote-tab" data-bs-toggle="tab" data-bs-target="#quote-pane" type="button" role="tab">Request a Quote</button>
                            </li> -->
                        </ul>
                        
                        <div class="tab-content p-4 border border-top-0" id="contactTabContent">
                            <!-- Contact Form -->
                            <div class="tab-pane fade show active" id="contact" role="tabpanel">
                                <form id="contactForm" action="" method="POST">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input type="text"  name="nom"  class="form-control" id="contactName" placeholder="Your Name" required>
                                                <label for="contactName">Votre nom</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input type="email" name="email" class="form-control" id="contactEmail" placeholder="Your Email" required>
                                                <label for="contactEmail">Votre email</label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-floating">
                                                <input type="text" name="objet" class="form-control" id="contactSubject" placeholder="Subject">
                                                <label for="contactSubject">Sujet</label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-floating">
                                                <textarea class="form-control" name="message" id="contactMessage" style="height: 120px" placeholder="Your Message" required></textarea>
                                                <label for="contactMessage">Votre message</label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-custom">Envoyer le message</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            
                            <!-- Quote Form -->
                            <!-- <div class="tab-pane fade" id="quote-pane" role="tabpanel">
                                <form id="quoteForm">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" id="quoteName" placeholder="Your Name" required>
                                                <label for="quoteName">Your Name</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input type="email" class="form-control" id="quoteEmail" placeholder="Your Email" required>
                                                <label for="quoteEmail">Your Email</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input type="tel" class="form-control" id="quotePhone" placeholder="Phone Number" required>
                                                <label for="quotePhone">Phone Number</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <select class="form-select" id="quoteService" required>
                                                    <option value="" selected disabled>Select Service</option>
                                                    <option value="cnc">CNC Machining</option>
                                                    <option value="fabrication">Metal Fabrication</option>
                                                    <option value="precision">Precision Engineering</option>
                                                    <option value="automation">Industrial Automation</option>
                                                </select>
                                                <label for="quoteService">Service Needed</label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-floating">
                                                <textarea class="form-control" id="quoteDetails" style="height: 120px" placeholder="Project Details" required></textarea>
                                                <label for="quoteDetails">Project Details</label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="quoteFile" class="mb-2">Upload Files (Drawings, Specifications)</label>
                                                <input type="file" class="form-control" id="quoteFile" multiple>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-custom">Request Quote</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div> -->
            </div>
        </div>
    </section>

    <!-- Map Section -->
    <section class="map-section">
        <div class="container-fluid p-0">
            <div class="row g-0">
                <div class="col-12">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3337.533511241283!2d-8.494329925681031!3d33.22632386089145!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xda91e1b3203029f%3A0x9b0fd59c8a916108!2sInox%20industrie%20sarl%20%3A%20Aciers%20inox%20%26%20Accessoires%20de%20d%C3%A9coration!5e0!3m2!1sfr!2sma!4v1755037693529!5m2!1sfr!2sma"
                        width="100%" 
                        height="450" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy">
                    </iframe>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer Section -->
    <footer class="footer-area pt-5 px-3 pb-3">
        <div class="container">
            <div class="row">
                <!-- About Company -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="footer-widget">
                        <h3 class="footer-logo mb-3">INOX<span style="color: var(--secBule);"> INDUSTRIE</span></h3>
                        <p class="mb-4">Leading industrial manufacturing solutions provider since 1995. We deliver precision-engineered components for critical applications worldwide.</p>
                        
                        <div class="social-icons">
                            <a href="https://www.facebook.com/profile.php?id=100076252924876" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                            <a href="https://www.facebook.com/profile.php?id=100076252924876" class="social-icon"><i class="fab fa-twitter"></i></a>
                            <a href="https://www.linkedin.com/company/inoxindustrie/posts/?feedView=all" class="social-icon"><i class="fab fa-linkedin-in"></i></a>
                            <a href="https://www.facebook.com/profile.php?id=100076252924876" class="social-icon"><i class="fab fa-instagram"></i></a>
                            <a href="https://www.facebook.com/profile.php?id=100076252924876" class="social-icon"><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="col-lg-2 col-md-6 mb-4">
                    <div class="footer-widget">
                        <h4 class="widget-title mb-4">Liens rapides</h4>
                        <ul class="footer-links">
                            <li><a href="index.html"><i class="fas fa-chevron-right me-2"></i> Accueil</a></li>
                            <li><a href="about-us.html"><i class="fas fa-chevron-right me-2"></i> À propos</a></li>
                            <li><a href="produit.php"><i class="fas fa-chevron-right me-2"></i> Produits</a></li>
                            <li><a href="contact.php"><i class="fas fa-chevron-right me-2"></i> Contact</a></li>
                        </ul>
                    </div>
                </div>

                <!-- Our Services -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="footer-widget">
                        <h4 class="widget-title mb-4">Our Services</h4>
                        <ul class="footer-links">
                            <li><a href="service.html"><i class="fas fa-chevron-right me-2"></i> CNC Machining</a></li>
                            <li><a href="service.html"><i class="fas fa-chevron-right me-2"></i> Metal Fabrication</a></li>
                            <li><a href="service.html"><i class="fas fa-chevron-right me-2"></i> Precision Engineering</a></li>
                            <li><a href="service.html"><i class="fas fa-chevron-right me-2"></i> Industrial Automation</a></li>
                            <li><a href="service.html"><i class="fas fa-chevron-right me-2"></i> Quality Control</a></li>
                        </ul>
                    </div>
                </div>

                <!-- Contact Info -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="footer-widget">
                        <h4 class="widget-title mb-4">Contactez-nous</h4>
                        <ul class="footer-contact">
                            <li class="mb-3">
                                <i class="fas fa-map-marker-alt me-3" style="color: var(--secBule);"></i>
                                <span>3 lot hasna jabrane, Av Khalil Jabran El Jadida</span>
                            </li>
                            <li class="mb-3">
                                <i class="fas fa-phone-alt me-3" style="color: var(--secBule);"></i>
                                <span>+05 22 46 03 04</span>
                            </li>
                            <li class="mb-3">
                                <i class="fas fa-envelope me-3" style="color: var(--secBule);"></i>
                                <span>contact@bowerindustrie.ma</span>
                            </li>
                            <li class="mb-3">
                                <i class="fas fa-clock me-3" style="color: var(--secBule);"></i>
                                <span>lun - ven: 08h30-18h00</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Copyright-->
            <div class="row pt-3 border-top border-secondary copyright">
                <div class="mb-3 text-center">
                    <p class="mb-0">&copy; 2025 INOX INDUSTRIE. Tous droits réservés.</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="assets/JS/jquery-3.6.0.min.js"></script>
    <script src="assets/JS/owl.carousel.min.js"></script>
    <!-- Bootstrap JS and AOS JS -->
    <script src="assets/JS/bootstrap.bundle.min.js"></script>
    <script src="assets/JS/aos.js"></script>
    <!-- main JS -->
    <script src="assets/JS/main.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if(window.location.hash === '#quote') {
                var triggerEl = document.querySelector('#quote-tab');
                if(triggerEl) {
                    var tab = new bootstrap.Tab(triggerEl);
                    tab.show();
                }
            }
        });
    </script>











<!-- Modal -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="successModalLabel">Message envoyé</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
      </div>
      <div class="modal-body">
        Votre message a été envoyé avec succès ! Nous vous répondrons bientôt.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal pour connexion obligatoire -->
<div class="modal fade" id="connectModal" tabindex="-1" aria-labelledby="connectModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="connectModalLabel">Attention</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
      </div>
      <div class="modal-body">
        Vous devez être connecté pour accéder au panier !
      </div>
      <div class="modal-footer">
        <a href="SignIn-SignUp-Form-main/login.php" class="btn btn-primary">Se connecter</a>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
      </div>
    </div>
  </div>
</div>




</script>
</body>
</html>