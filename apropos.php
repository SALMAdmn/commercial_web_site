<?php
session_start(); // Toujours démarrer la session en haut de la page
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elite Machinery</title>
    <!-- Bootstrap CSS -->
    <link href="assets/CSS/bootstrap.min.css" rel="stylesheet">
    <!-- AOS CSS -->
    <link href="assets/CSS/aos.css" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800;900&display=4wap">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/CSS/style.css">
    <link rel="stylesheet" href="assets/CSS/about-style.css">
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
            
            <a class="navbar-brand text-light"  href="index.php">
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
                        <a class="nav-link" aria-current="page" href="index.php">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link  active" href="apropos.php">À propos</a>
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

    <!-- Hero Banner -->
    <section class="about-hero" style="background: linear-gradient(#000000a8, #000000a8), url('assets/IMG/bg1.jpg');">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-12 text-center">
                    <h1 class="display-3 text-white mb-4" data-aos="fade-down">À propos</h1>
                    
                    <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="200">
                        <ol class="breadcrumb justify-content-center ">
                            <li class="breadcrumb-item"><a href="index.html" class="text-light">Accueil</a></li>
                            <li class="breadcrumb-item active" aria-current="page">À propos</li>
                        </ol>
                    </nav>
                    
                </div>
            </div>
        </div>
    </section>

    <!-- Our Story Section -->
    <section class="py-5 our-story">
        <div class="container">
            <div class="row align-items-center">
                
                <div class="col-lg-6 mb-4 mb-lg-0" data-aos="fade-right">
                    <h2 class="display-4 mb-4 ">Notre histoire</h2>
                    <p class="lead">Fondée en 2013, Inox Industrie a démarré comme une petite société familiale spécialisée dans l’acier inoxydable. Avec une vision claire : offrir des produits de qualité, durables et adaptés aux besoins du marché marocain.</p>
                    <p>Aujourd’hui, nous sommes un acteur reconnu à El Jadida, fournissant des symboles, pièces et articles en inox pour différents secteurs tels que l’artisanat, la restauration, la décoration et l’industrie. Notre parcours est marqué par la précision de nos découpes, l’innovation dans nos procédés et un engagement constant envers la satisfaction de nos clients.</p>
                    
                    <div class="achievements mt-4">
                        <div class="row">
                            <div class="col col-sm-4 mb-3">
                                <div class="achievement-box p-2 p-sm-3 text-center bg-white shadow-sm">
                                    <h3 class=" mb-0" data-target="10" data-suffix="+">0</h3>
                                    <p class="mb-0">Années d’expérience</p>
                                </div>
                            </div>
                            <div class="col col-sm-4 mb-3">
                                <div class="achievement-box p-2 p-sm-3 text-center bg-white shadow-sm">
                                    <h3 class=" mb-0" data-target="100" data-suffix="+">0</h3>
                                    <p class="mb-0">Clients au Maroc</p>
                                </div>
                            </div>
                            <div class="col col-sm-4 mb-3">
                                <div class="achievement-box p-2 p-sm-3 text-center bg-white shadow-sm">
                                    <h3 class=" mb-0" data-target="10" data-suffix="+">0</h3>
                                    <p class="mb-0">Collaborateurs engagés</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-lg-6" data-aos="fade-left">
                    <img src="assets/IMG/pic5.jpg" alt="Our Factory" class="img-fluid rounded shadow">
                </div>
            </div>
        </div>
    </section>

    <!-- Mission & Vision -->
    <section class="py-5 mission">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center mb-5">
                    <h2 class="display-4 mb-3">Nos valeurs</h2>
                    <p class="lead">Ce qui nous guide chaque jour</p>
                </div>
            </div>
            <div class="row">
                <!-- Mission -->
                <div class="col-md-6 mb-4" data-aos="fade-up">
                    <div class="core-value p-4 h-100">
                        <div class="icon-container mb-4">
                            <i class="fas fa-bullseye fa-3x text-primary"></i>
                        </div>
                        <h3 class="mb-3">Notre mission</h3>
                        <p>Fournir des solutions en acier inoxydable de haute qualité, alliant précision, durabilité et design, afin d’accompagner nos clients – professionnels comme particuliers – dans la réussite de leurs projets.</p>
                    </div>
                </div>
                
                <!-- Vision -->
                <div class="col-md-6 mb-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="core-value p-4 h-100">
                        <div class="icon-container mb-4">
                            <i class="fas fa-eye fa-3x text-primary"></i>
                        </div>
                        <h3 class="mb-3">Notre vision</h3>
                        <p>Devenir une référence nationale dans le domaine de l’inox, reconnue pour notre savoir-faire, la fiabilité de nos produits et l’innovation dans nos procédés de fabrication.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Choose Us -->
    <section class="py-5 why-choose-us">
        <div class="container-fluid container-lg">
            <div class="row">
                <div class="col-12 text-center mb-5">
                    <h2 class="display-4 mb-3">Pourquoi choisir Inox Industrie ?</h2>
                    <p class="lead">Les atouts qui nous distinguent</p>
                </div>
            </div>

            <div class="row g-4">
                <!-- Item 1 -->
                <div class="col-sm-6 col-md-3 " data-aos="fade-up" data-aos-delay="100">
                    <div class="feature-box p-4 text-center h-100 bg-white">
                        <div class="icon-container mx-auto mb-4 bg-white">
                            <i class="fas fa-cogs fa-3x text-primary"></i>
                        </div>
                        <h4 class="mb-3">Machines de pointe</h4>
                        <p>Grâce à nos équipements modernes de découpe et façonnage, nous garantissons une précision optimale et une finition irréprochable.</p>
                    </div>
                </div>
                
                <!-- Item 2 -->
                <div class="col-sm-6 col-md-3" data-aos="fade-up" data-aos-delay="200">
                    <div class="feature-box p-4 text-center h-100 bg-white">
                        <div class="icon-container mx-auto mb-4 bg-white">
                            <i class="fas fa-certificate fa-3x text-primary"></i>
                        </div>
                        <h4 class="mb-3">Qualité assurée</h4>
                        <p>Chaque pièce en inox est soumise à un contrôle rigoureux, afin d’offrir des produits fiables et durables.</p>
                    </div>
                </div>
                
                <!-- Item 3 -->
                <div class="col-sm-6 col-md-3" data-aos="fade-up" data-aos-delay="300">
                    <div class="feature-box p-4 text-center h-100 bg-white">
                        <div class="icon-container mx-auto mb-4 bg-white">
                            <i class="fas fa-users fa-3x text-primary"></i>
                        </div>
                        <h4 class="mb-3">Équipe qualifiée</h4>
                        <p>Notre équipe passionnée et expérimentée met son savoir-faire au service de vos projets, du plus simple au plus complexe.</p>
                    </div>
                </div>
                
                <!-- Item 4 -->
                <div class="col-sm-6 col-md-3" data-aos="fade-up" data-aos-delay="400">
                    <div class="feature-box p-4 text-center h-100 bg-white">
                        <div class="icon-container mx-auto mb-4 bg-white">
                            <i class="fas fa-leaf fa-3x text-primary"></i>
                        </div>
                        <h4 class="mb-3">Flexibilité et proximité</h4>
                        <p>En tant qu’entreprise locale à El Jadida, nous offrons un service personnalisé, adapté aux besoins spécifiques de chaque client.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Our Team -->
    <!-- <section class="py-5 bg-white team">
        <div class="container-fluid container-lg">
            <div class="row">
                <div class="col-12 text-center mb-5">
                    <h2 class="display-4 mb-3">Leadership Team</h2>
                    <p class="lead">The experienced professionals guiding our success</p>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 col-md-3 mb-4" data-aos="fade-up">
                    <div class="team-member text-center">
                        <div class="team-img mb-3 overflow-hidden">
                            <img src="assets/IMG/pic4.jpg" alt="CEO" class="img-fluid">
                        </div>
                        <h4 class="mb-1">Ahmed Mohamed</h4>
                        <p class="text-primary mb-3">Founder & CEO</p>
                        <div class="social-links">
                            <a href="#"><i class="fab fa-linkedin-in"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fas fa-envelope"></i></a>
                        </div>
                    </div>
                </div>
                
                <div class="col-sm-6 col-md-3 mb-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="team-member text-center">
                        <div class="team-img mb-3 overflow-hidden">
                            <img src="assets/IMG/pic3.jpg" alt="Operations Director" class="img-fluid">
                        </div>
                        <h4 class="mb-1">Maha Salah</h4>
                        <p class="text-primary mb-3">Operations Director</p>
                        <div class="social-links">
                            <a href="#"><i class="fab fa-facebook-f"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fas fa-envelope"></i></a>
                        </div>
                    </div>
                </div>
                
                <div class="col-sm-6 col-md-3 mb-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="team-member text-center">
                        <div class="team-img mb-3 overflow-hidden">
                            <img src="assets/IMG/pic1.jpg" alt="Technical Manager" class="img-fluid">
                        </div>
                        <h4 class="mb-1">Omar Khaled</h4>
                        <p class="text-primary mb-3">Technical Manager</p>
                        <div class="social-links">
                            <a href="#"><i class="fab fa-linkedin-in"></i></a>
                            <a href="#"><i class="fab fa-facebook-f"></i></a>
                            <a href="#"><i class="fas fa-envelope"></i></a>
                        </div>
                    </div>
                </div>
                
                <div class="col-sm-6 col-md-3 mb-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="team-member text-center">
                        <div class="team-img mb-3 overflow-hidden">
                            <img src="assets/IMG/pic7.jpg" alt="Quality Director" class="img-fluid">
                        </div>
                        <h4 class="mb-1">Ali Mahmoud</h4>
                        <p class="text-primary mb-3">Quality Director</p>
                        <div class="social-links">
                            <a href="#"><i class="fab fa-linkedin-in"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fas fa-envelope"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> -->
  <!-- Footer Section -->
    <footer class="footer-area pt-5 px-3 pb-3">
        <div class="container">
            <div class="row">
                <!-- About Company -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="footer-widget">
                        <h3 class="footer-logo mb-3">INOX<span style="color: var(--secBule);"> INDUSTRIE</span></h3>
                        <p class="mb-4">Spécialistes de la fabrication et de la transformation de l’inox, 
    nous proposons des solutions sur mesure alliant qualité, durabilité et précision. 
    Grâce à notre expertise et à des technologies modernes, nous accompagnons nos clients 
    dans la réalisation de projets industriels fiables et performants.</p>
                        
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
                            <li><a href="index.php"><i class="fas fa-chevron-right me-2"></i> Accueil</a></li>
                            <li><a href="apropos.php"><i class="fas fa-chevron-right me-2"></i> À propos</a></li>
                            <li><a href="produits.php"><i class="fas fa-chevron-right me-2"></i> Produits</a></li>
                            <li><a href="contact.php"><i class="fas fa-chevron-right me-2"></i> Contact</a></li>
                        </ul>
                    </div>
                </div>

                               <!-- Catégories Produits -->
<div class="col-lg-3 col-md-6 mb-4">
    <div class="footer-widget">
        <h4 class="widget-title mb-4">Catégories Produits</h4>
        <ul class="footer-links">
            <li><a href="produits.php?categorie=Alimentaire"><i class="fas fa-chevron-right me-2"></i> Alimentaire</a></li>
            <li><a href="produits.php?categorie=Construction"><i class="fas fa-chevron-right me-2"></i> Construction</a></li>
            <li><a href="produits.php?categorie=Transport"><i class="fas fa-chevron-right me-2"></i> Transport</a></li>
            <li><a href="produits.php?categorie=<?= urlencode('Énergie & Chimie') ?>"><i class="fas fa-chevron-right me-2"></i> Énergie & Chimie</a></li>
            <li><a href="produits.php?categorie=Domestique"><i class="fas fa-chevron-right me-2"></i> Domestique</a></li>
            <li><a href="produits.php?categorie=Medical"><i class="fas fa-chevron-right me-2"></i> Médical</a></li>
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
    <!-- Bootstrap JS and AOS JS -->
    <script src="assets/JS/bootstrap.bundle.min.js"></script>
    <script src="assets/JS/aos.js"></script>
    <!-- main JS -->
    <script src="assets/JS/main.js"></script>
    <script>
        function equalizeInfoHeight() {
            var maxHeight = 0;
            $(".achievements .achievement-box").css("height", "auto"); // Reset height

            $(".achievements .achievement-box").each(function () {
                var thisHeight = $(this).outerHeight();
                if (thisHeight > maxHeight) {
                maxHeight = thisHeight;
                }
            });

            $(".achievements .achievement-box").css("height", maxHeight + "px");
        }

        equalizeInfoHeight(); // Call on page load

        $(window).resize(function () {
            equalizeInfoHeight(); // Call on window resize
        });

        //////=> Statistics
        if ($(".our-story").length > 0) {
            const observer = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    startCounters();
                    observer.unobserve(entry.target); // نوقف المتابعة بعد ما نبدأ العد
                }
                });
            },
            { threshold: 0.5 }
            );

            // نحدد السيكشن اللي هنشوفه
            const aboutSection = $(".our-story")[0];
            observer.observe(aboutSection);

            function startCounters() {
                $(".achievement-box h3").each(function () {
                    const $this = $(this);
                    const target = +$this.attr("data-target");
                    const suffix = $this.attr("data-suffix") || ""; // + || %
                    const speed = 100; // السرعه (كلما قل الرقم كلما زادت السرعه)

                    const updateCount = () => {
                    const currentCount = +$this.text().replace(suffix, ""); // نمسح اللاحقة علشان ناخد الرقم فقط

                    if (currentCount < target) {
                        $this.text(Math.ceil(currentCount + target / speed) + suffix);
                        setTimeout(updateCount, 30);
                    } else {
                        $this.text(target + suffix); // added + || %
                    }
                    };

                    updateCount();
                });
            }
        }
    </script>


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


</body>
</html>