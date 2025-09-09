<?php
session_start();
if(!isset($_SESSION['email'])){
    header('location: ../admin.php');
    exit;
}

$con = mysqli_connect('localhost','root','','inox_industrie') or die('Impossible d\'acceder au serveur');
$sql = "SELECT * FROM admin WHERE email='".$_SESSION['email']."'";
$r = mysqli_query($con,$sql) or die('Erreur exec');
$d = mysqli_fetch_array($r);

if(!isset($_GET['id'])){
    die("ID produit manquant !");
}

$id = (int)$_GET['id'];

// Récupérer les données du produit
$sql_produit = "SELECT * FROM produits WHERE id = $id";
$res = $con->query($sql_produit);
if($res->num_rows == 0){
    die("Produit introuvable !");
}
$produit = $res->fetch_assoc();

$message = "";

// Traitement du formulaire
if(isset($_POST['submit'])){
    $description = $con->real_escape_string($_POST['description']);
    $prix = $con->real_escape_string($_POST['prix']);
    $stock = $con->real_escape_string($_POST['stock']);
    $categorie = $con->real_escape_string($_POST['categorie']);
    
    // Gestion discount si champs remplis
    $discount_percent = !empty($_POST['discount_percent']) ? (float)$_POST['discount_percent'] : 0;
    $date_debut_discount = !empty($_POST['date_debut_discount']) ? $_POST['date_debut_discount'] : null;
    $date_fin_discount = !empty($_POST['date_fin_discount']) ? $_POST['date_fin_discount'] : null;
    $prix_promo = $discount_percent > 0 ? $prix * (1 - $discount_percent / 100) : $prix;

    $image = $produit['image']; // image existante
    if(isset($_FILES['image']) && $_FILES['image']['name'] != ""){
        $image_tmp = $_FILES['image']['tmp_name'];
        $image = preg_replace("/[^a-zA-Z0-9.-]/", "_", basename($_FILES['image']['name']));
        move_uploaded_file($image_tmp, "../../assets/IMG/".$image);
    }

    $update_sql = "UPDATE produits 
                   SET description='$description', prix='$prix', stock='$stock', categorie='$categorie',
                       image='$image', discount_percent='$discount_percent', prix_promo='$prix_promo',
                       date_debut_discount='$date_debut_discount', date_fin_discount='$date_fin_discount'
                   WHERE id=$id";

    if($con->query($update_sql)){
        $message = "✅ Produit mis à jour avec succès !";
        $produit['description'] = $description;
        $produit['prix'] = $prix;
        $produit['stock'] = $stock;
        $produit['categorie'] = $categorie;
        $produit['image'] = $image;
        $produit['discount_percent'] = $discount_percent;
        $produit['prix_promo'] = $prix_promo;
        $produit['date_debut_discount'] = $date_debut_discount;
        $produit['date_fin_discount'] = $date_fin_discount;
    } else {
        $message = "❌ Erreur : " . $con->error;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Modifier un produit - Admin</title>
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
  <a class="nav-link text-white" data-bs-toggle="collapse" href="#produitMenu"><i class="fas fa-box"></i> Produits</a>
  <div class="collapse ps-3 show" id="produitMenu">
    <a href="admin_add_product.php" class="nav-link text-white">Ajouter Produit</a>
    <a href="afficher_produit.php" class="nav-link text-white">Afficher Produit</a>
    <a href="stock_moins3.php" class="nav-link text-white">Stock &lt; 3</a>
  </div>
</li>
<li>
  <a class="nav-link text-white" data-bs-toggle="collapse" href="#demandeMenu"><i class="fas fa-list"></i> Demandes</a>
  <div class="collapse ps-3" id="demandeMenu">
    <a href="../demande/envoye.php" class="nav-link text-white">Demandes envoyées</a>
    <a href="../demande/gerer.php" class="nav-link text-white">Gérer</a>
  </div>
</li>
<li><a href="../profil/monprofil.php" class="nav-link text-white"><i class="fas fa-user"></i> Profil</a></li>
<li><a href="../deconnexion.php" class="nav-link text-danger"><i class="fas fa-sign-out-alt"></i> Déconnexion</a></li>
</ul>
<hr>
<div class="text-center">
<small>Bonjour <strong><?php echo $d['username']; ?></strong> 👋</small>
</div>
</div>

<!-- Content -->
<div class="content">
<h2>Modifier un produit</h2>
<?php if(!empty($message)) echo "<div class='alert alert-info'>$message</div>"; ?>

<form method="POST" enctype="multipart/form-data" class="mt-3">
<div class="mb-3">
<label class="form-label">Nom du produit</label>
<input type="text" class="form-control" value="<?php echo $produit['nom']; ?>" readonly>
</div>

<div class="mb-3">
<label class="form-label">Description</label>
<textarea name="description" rows="4" class="form-control" required><?php echo $produit['description']; ?></textarea>
</div>

<div class="mb-3">
<label class="form-label">Prix</label>
<input type="number" step="0.01" min="0" name="prix" class="form-control" value="<?php echo $produit['prix']; ?>" required>
</div>

<div class="mb-3">
<label class="form-label">Stock</label>
<input type="number" name="stock" class="form-control" value="<?php echo $produit['stock']; ?>" required>
</div>
<!-- Champs Discount -->
<div class="mb-3">
<label class="form-label">Remise (%)</label>
<input type="number" step="0.01" min="0" max="100" name="discount_percent" class="form-control" value="<?php echo $produit['discount_percent'] ?? 0; ?>">
</div>

<div class="mb-3">
<label class="form-label">Date début remise</label>
<input type="date" name="date_debut_discount" class="form-control" value="<?php echo $produit['date_debut_discount'] ?? ''; ?>">
</div>

<div class="mb-3">
<label class="form-label">Date fin remise</label>
<input type="date" name="date_fin_discount" class="form-control" value="<?php echo $produit['date_fin_discount'] ?? ''; ?>">
</div>
<div class="mb-3">
<label class="form-label">Catégorie</label>
<select name="categorie" class="form-select" required>
<option value="Alimentaire" <?php if($produit['categorie']=="Alimentaire") echo "selected"; ?>>Alimentaire</option>
<option value="Construction" <?php if($produit['categorie']=="Construction") echo "selected"; ?>>Construction</option>
<option value="Transport" <?php if($produit['categorie']=="Transport") echo "selected"; ?>>Transport</option>
<option value="Énergie & Chimie" <?php if($produit['categorie']=="Énergie & Chimie") echo "selected"; ?>>Énergie & Chimie</option>
<option value="Domestique" <?php if($produit['categorie']=="Domestique") echo "selected"; ?>>Domestique</option>
<option value="Médical" <?php if($produit['categorie']=="Médical") echo "selected"; ?>>Médical</option>
</select>
</div>

<div class="mb-3">
<label class="form-label">Image</label><br>
<img src="../../assets/IMG/<?php echo $produit['image']; ?>" width="100" class="mb-2"><br>
<input type="file" name="image" class="form-control" accept="image/*">
</div>



<button type="submit" name="submit" class="btn btn-primary">Modifier Produit</button>
</form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
