<?php
session_start();
if(!isset($_SESSION['email'])){
    header('location: admin.php');
    exit;
}

$con = mysqli_connect('localhost','root','','inox_industrie') or die('Impossible d\'acceder au serveur');
$sql = "SELECT * FROM admin WHERE email='".$_SESSION['email']."'";
$r = mysqli_query($con,$sql) or die('Erreur exec');
$d = mysqli_fetch_array($r);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Dashboard</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- FontAwesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

  <style>
    body {
      min-height: 100vh;
      display: flex;
    }
    .sidebar {
      width: 250px;
      background: #194ed6ff;
      color: #fff;
      flex-shrink: 0;
    }
    .sidebar a {
      color: #fff;
      text-decoration: none;
    }
    .sidebar a:hover {
      background: #1040a6ff;
      color: #fff;
    }
    .content {
      flex-grow: 1;
      padding: 20px;
      background: #f8f9fa;
    }
  </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar d-flex flex-column p-3">
  <h3 class="text-center mb-4"><i class=""></i> Inox_Industrie</h3>
  <ul class="nav nav-pills flex-column mb-auto">
    <li class="nav-item">
      <a href="acceuil.php" class="nav-link text-white"><i class="fas fa-home"></i> Accueil</a>
    </li>
    <li>
      <a class="nav-link text-white" data-bs-toggle="collapse" href="#produitMenu"><i class="fas fa-box"></i> Produits</a>
      <div class="collapse ps-3" id="produitMenu">
        <a href="produit/admin_add_product.php" class="nav-link text-white">Ajouter Produit</a>
        <a href="produit/afficher_produit.php" class="nav-link text-white">Afficher Produit</a>
        <a href="produit/stock_moins3.php" class="nav-link text-white">Stock </a>
      </div>
    </li>
    <li>
      <a class="nav-link text-white" data-bs-toggle="collapse" href="#demandeMenu"><i class="fas fa-list"></i> Demandes</a>
      <div class="collapse ps-3" id="demandeMenu">
        <a href="produit/envoye.php" class="nav-link text-white">Demandes envoyées</a>
        <a href="demande/gerer.php" class="nav-link text-white">Gérer</a>
      </div>
    </li>
    <li>
      <a href="profil/monprofil.php" class="nav-link text-white"><i class="fas fa-user"></i> Profil</a>
    </li>
    <li>
      <a href="deconnexion.php" class="nav-link text-danger"><i class="fas fa-sign-out-alt"></i> Déconnexion</a>
    </li>
  </ul>
  <hr>
  <div class="text-center">
    <small>Bonjour <strong><?php echo $d['username']; ?></strong> 👋</small>
  </div>
</div>

<!-- Content -->
<div class="content">
  <h1>Dashboard Admin</h1>
  <p>Bienvenue sur votre espace d’administration.</p>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
