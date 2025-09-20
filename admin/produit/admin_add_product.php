<?php
session_start();
if(!isset($_SESSION['email'])){
    header('location: ../admin.php');
    exit;
}

$conn = new mysqli("localhost", "root", "", "inox_industrie");
if($conn->connect_error) die("Connexion échouée : " . $conn->connect_error);

// Récupération info admin connecté
$sql = "SELECT * FROM admin WHERE email='".$_SESSION['email']."'";
$r = $conn->query($sql);
$admin = $r->fetch_assoc();

// Message après ajout
$message = "";

// Traitement du formulaire
if(isset($_POST['submit'])){
    $nom = $conn->real_escape_string($_POST['nom']);
    $description = $conn->real_escape_string($_POST['description']);
    $prix = $conn->real_escape_string($_POST['prix']);
    $stock = $conn->real_escape_string($_POST['stock']);
    $categorie = $conn->real_escape_string($_POST['categorie']);

    $image = basename($_FILES['image']['name']);
    $image = preg_replace("/[^a-zA-Z0-9.-]/", "_", $image);
    $target = "../../assets/IMG/".$image;

    $discount_percent = !empty($_POST['discount_percent']) ? $conn->real_escape_string($_POST['discount_percent']) : NULL;
    $date_debut_discount = !empty($_POST['date_debut_discount']) ? $conn->real_escape_string($_POST['date_debut_discount']) : NULL;
    $date_fin_discount = !empty($_POST['date_fin_discount']) ? $conn->real_escape_string($_POST['date_fin_discount']) : NULL;

    // Calcul automatique du prix promo si % est défini
    $prix_promo = NULL;
    if($discount_percent !== NULL){
        $prix_promo = $prix - ($prix * $discount_percent / 100);
    }

    if(move_uploaded_file($_FILES['image']['tmp_name'], $target)){
        $sql = "INSERT INTO produits 
(nom, description, image, prix, stock, categorie, prix_promo, discount_percent, date_debut_discount, date_fin_discount)
VALUES
('$nom','$description','$image','$prix','$stock','$categorie','$prix_promo','$discount_percent','$date_debut_discount','$date_fin_discount')";
        if($conn->query($sql) === TRUE){
            $message = "✅ Produit ajouté avec succès !";
        } else {
            $message = "❌ Erreur SQL : " . $conn->error;
        }
    } else {
        $message = "⚠️ Erreur lors de l'upload de l'image.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Ajouter un produit - Admin</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<style>
body { min-height: 100vh; display: flex; }
.sidebar { width: 250px; background: #194ed6ff; color: #fff; flex-shrink: 0; }
.sidebar a { color: #fff; text-decoration: none; }
.sidebar a:hover { background: #1040a6ff; color: #fff; }
.content { flex-grow: 1; padding: 20px; background: #f8f9fa; }
</style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar d-flex flex-column p-3">
  <h3 class="text-center mb-4">Inox_Industrie</h3>
  <ul class="nav nav-pills flex-column mb-auto">
    <li><a href="../acceuil.php" class="nav-link text-white"><i class="fas fa-home"></i> Accueil</a></li>
    <li>
      <a class="nav-link text-white" data-bs-toggle="collapse" href="#produitMenu">
        <i class="fas fa-box"></i> Produits
      </a>
      <div class="collapse ps-3" id="produitMenu">
        <a href="admin_add_product.php" class="nav-link text-white">Ajouter Produit</a>
        <a href="afficher_produit.php" class="nav-link text-white">Afficher Produit</a>
      </div>
    </li>
    <li><a href="envoye.php" class="nav-link text-white"><i class="fas fa-list"></i> Demandes</a></li>
    <li><a href="../monprofil.php" class="nav-link text-white"><i class="fas fa-user"></i> Profil</a></li>
    <li><a href="../deconnexion.php" class="nav-link text-danger"><i class="fas fa-sign-out-alt"></i> Déconnexion</a></li>
  </ul>
  <hr>
  <div class="text-center">
    <small>Bonjour <strong><?= htmlspecialchars($admin['username']); ?></strong> 👋</small>
  </div>
</div>

<!-- Content -->
<div class="content">
<h2>Ajouter un produit</h2>

<?php if(!empty($message)) echo "<div class='alert alert-info'>$message</div>"; ?>

<form method="POST" enctype="multipart/form-data" class="mt-3">
  <div class="mb-3">
    <label class="form-label">Nom du produit</label>
    <input type="text" name="nom" class="form-control" required>
  </div>

  <div class="mb-3">
    <label class="form-label">Description</label>
    <textarea name="description" rows="4" class="form-control" required></textarea>
  </div>

  <div class="mb-3">
    <label class="form-label">Prix</label>
    <input type="number" step="0.01" min="0" name="prix" class="form-control" required>
  </div>

  <div class="mb-3">
    <label class="form-label">Pourcentage de réduction (%)</label>
    <input type="number" min="0" max="100" name="discount_percent" class="form-control">
  </div>

  <div class="mb-3">
    <label class="form-label">Date début promotion</label>
    <input type="date" name="date_debut_discount" class="form-control">
  </div>

  <div class="mb-3">
    <label class="form-label">Date fin promotion</label>
    <input type="date" name="date_fin_discount" class="form-control">
  </div>

  <div class="mb-3">
    <label class="form-label">Stock</label>
    <input type="number" name="stock" class="form-control" required>
  </div>

  <div class="mb-3">
    <label class="form-label">Catégorie</label>
    <select name="categorie" class="form-select" required>
      <option value="">--Sélectionnez--</option>
      <option value="Alimentaire">Alimentaire</option>
      <option value="Construction">Construction</option>
      <option value="Transport">Transport</option>
      <option value="Énergie & Chimie">Énergie & Chimie</option>
      <option value="Domestique">Domestique</option>
      <option value="Médical">Médical</option>
    </select>
  </div>

  <div class="mb-3">
    <label class="form-label">Image</label>
    <input type="file" name="image" class="form-control" accept="image/*" required>
  </div>

  <button type="submit" name="submit" class="btn btn-primary">Ajouter produit</button>
</form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
