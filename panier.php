<?php
session_start();
$conn = new mysqli("localhost", "root", "", "inox_industrie");
if ($conn->connect_error) die("Connexion échouée : " . $conn->connect_error);

if (!isset($_SESSION['user_id'])) {
    echo "<p class='alert alert-warning'>Veuillez vous connecter pour voir votre panier.</p>";
    exit();
}

$user_id = $_SESSION['user_id'];

// Supprimer un produit du panier
if (isset($_GET['remove'])) {
    $remove_id = intval($_GET['remove']);
    $conn->query("DELETE FROM paniers WHERE user_id=$user_id AND produit_id=$remove_id");
    header("Location: panier.php");
    exit();
}

// Mettre à jour la quantité
if (isset($_GET['update']) && isset($_GET['qty'])) {
    $update_id = intval($_GET['update']);
    $new_qty = max(1, intval($_GET['qty']));

    // Vérifier le stock
    $res = $conn->query("SELECT stock FROM produits WHERE id=$update_id");
    if ($res && $row = $res->fetch_assoc()) {
        $stock = intval($row['stock']);
        if ($new_qty > $stock) $new_qty = $stock;
        $conn->query("UPDATE paniers SET quantite=$new_qty WHERE user_id=$user_id AND produit_id=$update_id");
    }
    header("Location: panier.php");
    exit();
}

// Récupérer le panier
$result = $conn->query("
    SELECT p.*, pa.quantite 
    FROM paniers pa
    JOIN produits p ON pa.produit_id = p.id
    WHERE pa.user_id = $user_id
");

$empty_cart = ($result->num_rows === 0);
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
    <style>
        section.container {
    margin-bottom: 0 !important;
}

    </style>
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
                        <a class="nav-link" href="produits.php">Produits</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.php">Contact</a>
                    </li>

                </ul>
                
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0 d-flex gap-2">
             
                    
                <?php if (isset($_SESSION['user_id'])): ?>
                <a class="btn btn-outline-light   active" href="panier.php">
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
  













    <!-- ici le contenu de panier -->
<!-- ✅ CONTENU DU PANIER -->
<section class="container mt-5 mb-0">
    <h2 class="mb-4" style="margin-top: 70px;">Mon Panier</h2>

    <?php if ($empty_cart): ?>
        <p class="alert alert-info">Votre panier est vide.</p>
    <?php else: ?>
        <table class="table table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Produit</th>
                    <th>Prix unitaire</th>
                    <th>Quantité</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
$total = 0;
while ($row = $result->fetch_assoc()) {
    $quantite = intval($row['quantite']);
    
    // Gestion du discount actif
    $prix_utilise = $row['prix'];
    $discount = 0;
    if(!empty($row['prix_promo']) && !empty($row['date_debut_discount']) && !empty($row['date_fin_discount'])) {
        $now = date('Y-m-d H:i:s');
        if($now >= $row['date_debut_discount'] && $now <= $row['date_fin_discount']) {
            $prix_utilise = $row['prix_promo'];
            $discount = $row['discount_percent'];
        }
    }

    $subtotal = $prix_utilise * $quantite;
    $total += $subtotal;

    echo '<tr>
        <td>
            <img src="assets/IMG/'.$row['image'].'" alt="'.$row['nom'].'" style="width:80px; margin-right:10px;">
            '.$row['nom'].'
        </td>
        <td>';
            if($discount > 0){
                echo '<del>'.$row['prix'].' DH</del> '.$prix_utilise.' DH <small class="text-success">(-'.$discount.'%)</small>';
            } else {
                echo $prix_utilise.' DH';
            }
    echo '</td>
        <td>
            <form method="get" action="panier.php" class="d-flex align-items-center">
                <input type="hidden" name="update" value="'.$row['id'].'">
                <button type="submit" name="qty" value="'.max(1,$quantite-1).'" class="btn btn-sm btn-outline-secondary me-2">-</button>
                <input type="text" name="qty_current" value="'.$quantite.'" class="form-control text-center" style="width:60px;" readonly>
                <button type="submit" name="qty" value="'.($quantite+1).'" class="btn btn-sm btn-outline-secondary ms-2">+</button>
            </form>
            <small class="text-muted">Stock max : '.$row['stock'].'</small>
        </td>
        <td>'.$subtotal.' DH</td>
        <td>
            <a href="panier.php?remove='.$row['id'].'" class="btn btn-danger btn-sm">
                <i class="fas fa-trash"></i> Supprimer
            </a>
        </td>
    </tr>';
}
?>
<tr>
    <td colspan="3"><strong>Total général</strong></td>
    <td colspan="2"><strong><?php echo $total; ?> DH</strong></td>
</tr>


            </tbody>
        </table>

        <div class="text-end">
            <a href="demande.php" class="btn btn-primary btn-lg">
                Valider la demande / Obtenir un devis
            </a>
        </div>
    <?php endif; ?>
</section>

    <!-- End  contenu de panier  -------- -->


















  
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

</body>
</html>