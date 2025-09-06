<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$conn = new mysqli("localhost", "root", "", "inox_industrie");
if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}

// Vérifier que l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$user_id = $_SESSION['user_id'];

// Ajouter au panier
if (isset($_POST['add_cart'])) {
    $produit_id = intval($_POST['produit_id']);
    $quantite   = max(1, intval($_POST['quantite']));

    // Vérifier stock
    $result = $conn->query("SELECT stock FROM produits WHERE id=$produit_id");
    if ($row = $result->fetch_assoc()) {
        $stock = intval($row['stock']);
        if ($quantite > $stock) {
            $quantite = $stock;
        }

        // Vérifier si produit existe déjà dans le panier
        $check = $conn->query("SELECT * FROM paniers WHERE user_id=$user_id AND produit_id=$produit_id");
        if ($check->num_rows > 0) {
            $conn->query("UPDATE paniers SET quantite=$quantite WHERE user_id=$user_id AND produit_id=$produit_id");
        } else {
            $conn->query("INSERT INTO paniers(user_id, produit_id, quantite) VALUES($user_id, $produit_id, $quantite)");
        }
    }
    header("Location: produits.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Case Studies | Elite Machinery</title>
    <!-- Bootstrap CSS -->
    <link href="assets/CSS/bootstrap.min.css" rel="stylesheet">
    <!-- AOS CSS -->
    <link href="assets/CSS/aos.css" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800;900&display=4wap">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/CSS/style.css">
    <link rel="stylesheet" href="assets/CSS/case-studies-style.css">
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
                        <a class="nav-link" href="apropos.php">À propos</a>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="capabilities.html">Our Capabilities</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="industries.html">Industries</a>
                    </li> -->
                    <li class="nav-item">
                        <a class="nav-link  active" href="produits.php">Produits</a>
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
    <section class="case-studies-hero" style="background: linear-gradient(#000000a8, #000000a8), url('assets/IMG/bg1.jpg');">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    
                    <!-- Hero Content -->
                    <div class="hero-content text-center">
                        <h1 class="display-3 text-white mb-4" data-aos="fade-down">Nos Produits</h1>
                        <p class="lead text-light" data-aos="fade-up" data-aos-delay="100">Découvrez notre large gamme d’articles en acier inoxydable, conçus pour allier qualité, durabilité et design. Que ce soit pour des projets industriels, artisanaux ou décoratifs, nous proposons des solutions adaptées à vos besoins avec une finition de précision.</p>
                    </div>
                    
                    <!-- Breadcrumb -->
                    <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="200">
                        <ol class="breadcrumb justify-content-center position-relative">
                            <li class="breadcrumb-item"><a href="index.html" class="text-light">Accueil</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Produits</li>
                        </ol>
                    </nav>

                </div>
            </div>
        </div>
    </section>

    <!-- Case Studies Filter -->
    <section class="case-studies-filter py-2 py-lg-4">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <ul class="filter-list">
                        <li class="active" data-filter="all">Nos Produits en Inox</li>
                        <li data-filter="automotive">Automotive</li>
                        <li data-filter="aerospace">Aerospace</li>
                        <li data-filter="medical">Medical</li>
                        <li data-filter="energy">Energy</li>
                        <li data-filter="defense">Defense</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Case Studies Grid -->
    <section class="case-studies-grid py-5">
        <div class="container">
            <div class="row">
            
                <!-- Case Study 1 -->
                <!-- <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-category="automotive">
                    <div class="case-study-card">
                        
                        <div class="case-study-img">
                            <img src="assets/IMG/st1.jpg" alt="Automotive Case Study" class="img-fluid">
                            <div class="case-study-badge">Automotive</div>
                        </div>
                        
                        <div class="case-study-content">
                            <h3>Automotive Assembly Line Optimization</h3>
                            <p class="case-study-excerpt">How we helped a leading car manufacturer reduce production time by 40%</p>
                            <div class="case-study-results">
                                <div class="result-item">
                                    <i class="fas fa-chart-line"></i>
                                    <span>40% Efficiency Increase</span>
                                </div>
                                <div class="result-item">
                                    <i class="fas fa-dollar-sign"></i>
                                    <span>$2M Annual Savings</span>
                                </div>
                            </div>
                            <a href="service.html" class="btn btn-custom">View Full Case Study</a>
                        </div>
                    </div>
                </div> -->
                <?php

$sql = "SELECT * FROM produits";
$result = $conn->query($sql);

if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        ?>
        <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-category="<?= $row['categorie'] ?>">
            <div class="case-study-card">
                <div class="case-study-img">
                    <img src="assets/IMG/<?= $row['image'] ?>" alt="<?= $row['nom'] ?>" class="img-fluid">
                    <div class="case-study-badge"><?= $row['categorie'] ?></div>
                </div>
                <div class="case-study-content">
                    <h3><?= $row['nom'] ?></h3>
                    <p class="case-study-excerpt"><?= $row['description'] ?></p>
                    <div class="case-study-results">
                        <div class="result-item">
                            <i class="fas fa-dollar-sign"></i>
                            <span>Prix : <?= $row['prix'] ?> DH</span>
                        </div>
                        <div class="result-item">
                            <i class="fas fa-box"></i>
                            <span>Stock : <?= $row['stock'] ?></span>
                        </div>
                    </div>

                    <form class="add-to-cart-form" method="POST" action="produits.php" data-id="<?= $row['id'] ?>">
                        <input type="hidden" name="produit_id" value="<?= $row['id'] ?>">
                        <input type="number" name="quantite" value="1" min="1" max="<?= $row['stock'] ?>" class="form-control mb-2">
                        <button type="submit" class="btn btn-custom">Ajouter au panier</button>
                    </form>
                </div>
            </div>
        </div>
        <?php
    }
} else {
    echo "<p>Aucun produit disponible pour le moment.</p>";
}
?>



     

            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-5 bg-adds" style="background: linear-gradient(#000000a8 , #000000a8), url('assets/IMG/info.jpg');">
        <div class="container">
            <div class="row justify-content-center">
               
                <div class="col-lg-8 text-center">
                    <h2 class="text-white mb-4" data-aos="fade-up">Obtenez une estimation personnalisée</h2>
                    <p class="lead text-light mb-5" data-aos="fade-up" data-aos-delay="100">Demandez dès aujourd’hui votre devis sur mesure et recevez une estimation claire et rapide, adaptée à vos besoins en inox.</p>
                    <a href="contact.html#quote" class="btn btn-custom btn-lg" data-aos="fade-up" data-aos-delay="200">Obtenir un devis</a>
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
                        <h3 class="footer-logo mb-3">Elite<span style="color: var(--secBule);">Machinery</span></h3>
                        <p class="mb-4">Leading industrial manufacturing solutions provider since 1995. We deliver precision-engineered components for critical applications worldwide.</p>
                        
                        <div class="social-icons">
                            <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="social-icon"><i class="fab fa-linkedin-in"></i></a>
                            <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                            <a href="#" class="social-icon"><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="col-lg-2 col-md-6 mb-4">
                    <div class="footer-widget">
                        <h4 class="widget-title mb-4">Quick Links</h4>
                        <ul class="footer-links">
                            <li><a href="index.html"><i class="fas fa-chevron-right me-2"></i> Home</a></li>
                            <li><a href="about-us.html"><i class="fas fa-chevron-right me-2"></i> About Us</a></li>
                            <li><a href="capabilities.html"><i class="fas fa-chevron-right me-2"></i> Our Capabilities</a></li>
                            <li><a href="industries.html"><i class="fas fa-chevron-right me-2"></i> Industries</a></li>
                            <li><a href="case-studies.html"><i class="fas fa-chevron-right me-2"></i> Case Studies</a></li>
                            <li><a href="contact.html"><i class="fas fa-chevron-right me-2"></i> Contact</a></li>
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
                        <h4 class="widget-title mb-4">Contact Us</h4>
                        <ul class="footer-contact">
                            <li class="mb-3">
                                <i class="fas fa-map-marker-alt me-3" style="color: var(--secBule);"></i>
                                <span>Industrial Zone 45, Building 12, Cairo, Egypt</span>
                            </li>
                            <li class="mb-3">
                                <i class="fas fa-phone-alt me-3" style="color: var(--secBule);"></i>
                                <span>+20 123 456 7890</span>
                            </li>
                            <li class="mb-3">
                                <i class="fas fa-envelope me-3" style="color: var(--secBule);"></i>
                                <span>info@elitemachinery.com</span>
                            </li>
                            <li class="mb-3">
                                <i class="fas fa-clock me-3" style="color: var(--secBule);"></i>
                                <span>Mon-Fri: 8:00 - 17:00</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Copyright-->
            <div class="row pt-3 border-top border-secondary copyright">
                <div class="mb-3 text-center">
                    <p class="mb-0">&copy; 2025 EliteMachinery. All Rights Reserved.</p>
                    <span class="d-block d-sm-inline mt-2 mt-sm-0">Powered By: <a href="https://ideaworldweb.com" target="_blank" style="color: var(--secBule);">Idea World Web</a></span>
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
        $(document).ready(function() {
            // Initialize filter functionality
            $('.filter-list li').click(function() {
                $('.filter-list li').removeClass('active');
                $(this).addClass('active');
                
                const filter = $(this).data('filter');
                
                if (filter === 'all') {
                    $('.case-studies-grid .col-lg-4').show();
                } else {
                    $('.case-studies-grid .col-lg-4').hide();
                    $(`.case-studies-grid .col-lg-4[data-category="${filter}"]`).show();
                }
                AOS.init();
            });
        });
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





















<script>
$(document).ready(function() {
    $('.add-to-cart-form').submit(function(e){
        e.preventDefault(); // empêche le rechargement de la page

        var produitId = $(this).data('id');
        var quantite = $(this).find('input[name="quantite"]').val();

        $.ajax({
            url: 'add_to_cart.php',
            method: 'POST',
            data: { produit_id: produitId, quantite: quantite },
            success: function(response){
                // alert('Produit ajouté au panier !');  <-- Supprimé ou commenté
                // tu peux mettre à la place un compteur dans le panier si tu veux
            },
            error: function(){
                 alert('Erreur lors de l\'ajout au panier.'); 
            }
        });
    });
});
</script>



</body>
</html>