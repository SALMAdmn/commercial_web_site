<?php
session_start();
if(!isset($_SESSION['email'])){
    header('location: ../admin.php');
    exit;
}

$conn = new mysqli("localhost", "root", "", "inox_industrie");
if($conn->connect_error) die("Connexion échouée : " . $conn->connect_error);

// Récupération info admin
$sql = "SELECT * FROM admin WHERE email='".$_SESSION['email']."'";
$r = $conn->query($sql);
$admin = $r->fetch_assoc(); // <- Utiliser $admin pour être cohérent avec le nav

// Vérifier si l'id est fourni
if(!isset($_GET['id'])){
    header('location: envoye.php');
    exit;
}

$id = intval($_GET['id']);
$demande = $conn->query("SELECT * FROM demandes WHERE id=$id")->fetch_assoc();
if(!$demande){
    die("Demande introuvable.");
}

// Traitement du formulaire
if(isset($_POST['valider_envoi'])){
    if(isset($_FILES['preuve']) && $_FILES['preuve']['error'] == 0){
        $ext = pathinfo($_FILES['preuve']['name'], PATHINFO_EXTENSION);
        $filename = 'preuve_'.$id.'_'.time().'.'.$ext;
        $upload_dir = __DIR__ . '/uploads/';

        if(!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);

        if(move_uploaded_file($_FILES['preuve']['tmp_name'], $upload_dir.$filename)){
            $conn->query("UPDATE demandes SET preuve='$filename', statut='valide', date_validation=NOW() WHERE id=$id");
            $demande['preuve'] = $filename;
            $demande['statut'] = 'valide';
            $demande['date_validation'] = date('Y-m-d H:i:s');
            $success = "La preuve a été uploadée et la demande validée.";
        } else {
            $error = "Erreur lors de l'upload du fichier.";
        }
    } else {
        $error = "Veuillez sélectionner une image.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Validation de la demande</title>
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


<div class="content">
<h2 class="mb-4">Validation de la demande</h2>

<?php if(isset($success)): ?>
<div class="alert alert-success"><?= $success ?></div>
<?php elseif(isset($error)): ?>
<div class="alert alert-danger"><?= $error ?></div>
<?php endif; ?>

<div class="card">
<div class="card-body">
<p><strong>ID :</strong> <?= $demande['id'] ?></p>
<p><strong>Email :</strong> <?= htmlspecialchars($demande['email']) ?></p>
<p><strong>Total :</strong> <?= $demande['total'] ?> DH</p>
<p><strong>Produits :</strong><br>
<?php
$produits = json_decode($demande['produits'], true);
foreach($produits as $p){
    echo "- ".htmlspecialchars($p['nom'])." x".$p['quantite']." (".$p['prix']." DH)<br>";
}
?>
</p>

<form method="post" enctype="multipart/form-data">
<div class="mb-3">
    <label for="preuve" class="form-label">📥 Télécharger preuve de paiement (photo)</label>
    <input type="file" class="form-control" id="preuve" name="preuve" accept="image/*">
</div>
<button type="submit" name="valider_envoi" class="btn btn-success">✅ Valider l’envoi de commande</button>
<a href="envoye.php" class="btn btn-secondary">⬅ Retour</a>
</form>

<?php if(!empty($demande['preuve'])): ?>
<hr>
<p><strong>Preuve déjà uploadée :</strong></p>
<img src="uploads/<?= $demande['preuve'] ?>" alt="Preuve paiement" style="max-width:200px;">
<?php endif; ?>

</div>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
