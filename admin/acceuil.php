<?php
session_start();
if(!isset($_SESSION['email'])){
    header('location: ../admin.php');
    exit;
}

$conn = new mysqli("localhost", "root", "", "inox_industrie");
if($conn->connect_error) die("Connexion échouée : " . $conn->connect_error);

// Info admin connecté
$sql = "SELECT * FROM admin WHERE email='".$_SESSION['email']."'";
$r = $conn->query($sql);
$admin = $r->fetch_assoc();

// Compteurs
// Nombre de produits
$res = $conn->query("SELECT COUNT(*) as total FROM produits");
$nb_produits = $res->fetch_assoc()['total'];

// Nombre de demandes validées
$res = $conn->query("SELECT COUNT(*) as total FROM demandes WHERE statut='valide'");
$nb_valide = $res->fetch_assoc()['total'];

// Nombre de demandes non validées
$res = $conn->query("SELECT COUNT(*) as total FROM demandes WHERE statut='en_attente'");
$nb_non_valide = $res->fetch_assoc()['total'];

// Nombre d'admins
$res = $conn->query("SELECT COUNT(*) as total FROM admin");
$nb_admin = $res->fetch_assoc()['total'];

// Autres informations (exemple : total ventes)
$res = $conn->query("SELECT SUM(total) as total_ventes FROM demandes WHERE statut='valide'");
$total_ventes = $res->fetch_assoc()['total_ventes'] ?? 0;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Dashboard Admin</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<style>
body { min-height: 100vh; display: flex; }
.sidebar { width: 250px; background: #194ed6ff; color: #fff; flex-shrink: 0; }
.sidebar a { color: #fff; text-decoration: none; }
.sidebar a:hover { background: #1040a6ff; color: #fff; }
.content { flex-grow: 1; padding: 20px; background: #f8f9fa; }
.card { color: #fff; }
.bg-card { 
    background-color: #3498db; /* couleur unique pour tous les cards */
    color: #fff; /* texte blanc */
}

</style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar d-flex flex-column p-3">
  <h3 class="text-center mb-4">Inox_Industrie</h3>
  <ul class="nav nav-pills flex-column mb-auto">
    <li><a href="acceuil.php" class="nav-link text-white"><i class="fas fa-home"></i> Accueil</a></li>
    <li>
      <a class="nav-link text-white" data-bs-toggle="collapse" href="#produitMenu">
        <i class="fas fa-box"></i> Produits
      </a>
      <div class="collapse ps-3" id="produitMenu">
        <a href="produit/admin_add_product.php" class="nav-link text-white">Ajouter Produit</a>
        <a href="produit/afficher_produit.php" class="nav-link text-white">Afficher Produit</a>
      </div>
    </li>
    <li><a href="produit/envoye.php" class="nav-link text-white"><i class="fas fa-list"></i> Demandes</a></li>
    <li><a href="monprofil.php" class="nav-link text-white"><i class="fas fa-user"></i> Profil</a></li>
    <li><a href="deconnexion.php" class="nav-link text-danger"><i class="fas fa-sign-out-alt"></i> Déconnexion</a></li>
  </ul>
  <hr>
  <div class="text-center">
    <small>Bonjour <strong><?= htmlspecialchars($admin['username']); ?></strong> 👋</small>
  </div>
</div>


<div class="content">
<h2 class="mb-4">Dashboard</h2>

<div class="row g-4">
  <div class="col-md-3">
    <div class="card text-white bg-card shadow h-100">
      <div class="card-body d-flex flex-column justify-content-center align-items-center">
        <h5 class="card-title"><i class="fas fa-box fa-2x"></i> Produits</h5>
        <h3 class="card-text"><?= $nb_produits ?></h3>
      </div>
    </div>
  </div>

  <div class="col-md-3">
    <div class="card text-white bg-card shadow h-100">
      <div class="card-body d-flex flex-column justify-content-center align-items-center">
        <h5 class="card-title"><i class="fas fa-check-circle fa-2x"></i> Validées</h5>
        <h3 class="card-text"><?= $nb_valide ?></h3>
      </div>
    </div>
  </div>

  <div class="col-md-3">
    <div class="card text-white bg-card shadow h-100">
      <div class="card-body d-flex flex-column justify-content-center align-items-center">
        <h5 class="card-title"><i class="fas fa-clock fa-2x"></i> Non validées</h5>
        <h3 class="card-text"><?= $nb_non_valide ?></h3>
      </div>
    </div>
  </div>

  <div class="col-md-3">
    <div class="card text-white bg-card shadow h-100">
      <div class="card-body d-flex flex-column justify-content-center align-items-center">
        <h5 class="card-title"><i class="fas fa-user-shield fa-2x"></i> Admins</h5>
        <h3 class="card-text"><?= $nb_admin ?></h3>
      </div>
    </div>
  </div>

  <div class="col-md-3">
    <div class="card text-white bg-card shadow h-100">
      <div class="card-body d-flex flex-column justify-content-center align-items-center">
        <h5 class="card-title"><i class="fas fa-money-bill-wave fa-2x"></i> Total Ventes</h5>
        <h3 class="card-text"><?= $total_ventes ?> DH</h3>
      </div>
    </div>
  </div>
</div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
