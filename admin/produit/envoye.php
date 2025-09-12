<?php
session_start();
if(!isset($_SESSION['email'])){
    header('location: admin.php');
    exit;
}

$con = mysqli_connect('localhost','root','','inox_industrie') or die('Impossible d\'accéder au serveur');
$sql = "SELECT * FROM admin WHERE email='".$_SESSION['email']."'";
$r = mysqli_query($con,$sql) or die('Erreur exec');
$d = mysqli_fetch_array($r);

// =====================
// Connexion DB pour demandes
// =====================
$conn = new mysqli("localhost", "root", "", "inox_industrie");
if ($conn->connect_error) die("Erreur : " . $conn->connect_error);

// Enregistrer nouvelle demande (depuis panier)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['produits'])) {
    $email = $_POST['email'];
    $total = $_POST['total_general'];
    $produits = json_encode($_POST['produits'], JSON_UNESCAPED_UNICODE);

$sql = "INSERT INTO demandes (email, produits, total, statut, date_demande) 
        VALUES (?, ?, ?, 'en_attente', NOW())";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssd", $email, $produits, $total);

    $stmt->execute();
}

// Validation d’une demande
if (isset($_GET['valider'])) {
    $id = intval($_GET['valider']);
    $sql = "UPDATE demandes SET statut='valide', date_validation=NOW() WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: envoye.php");
    exit;
}

// Récupération des demandes
$result = $conn->query("SELECT * FROM demandes ORDER BY date_demande DESC");


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['produits'])) {
    $email = $_POST['email'];
    $total = $_POST['total_general'];
    $produits = json_encode($_POST['produits'], JSON_UNESCAPED_UNICODE);

    $sql = "INSERT INTO demandes (email, produits, total, statut, date_demande) 
            VALUES (?, ?, ?, 'en_attente', NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssd", $email, $produits, $total);
    $stmt->execute();

    // ✅ Supprimer les produits du panier après l'envoi de la demande
    $stmt_del = $conn->prepare("DELETE FROM paniers WHERE user_id = ?");
    $stmt_del->bind_param("i", $_SESSION['user_id']); // ou email si tu utilises email
    $stmt_del->execute();

    echo json_encode(['success' => true]); // pour AJAX
    exit;
}


?>


<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin - Demandes envoyées</title>

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
  <h3 class="text-center mb-4">Inox_Industrie</h3>
  <ul class="nav nav-pills flex-column mb-auto">
    <li><a href="acceuil.php" class="nav-link text-white"><i class="fas fa-home"></i> Accueil</a></li>
    <li>
      <a class="nav-link text-white" data-bs-toggle="collapse" href="#produitMenu"><i class="fas fa-box"></i> Produits</a>
      <div class="collapse ps-3" id="produitMenu">
        <a href="produit/admin_add_product.php" class="nav-link text-white">Ajouter Produit</a>
        <a href="produit/afficher_produit.php" class="nav-link text-white">Afficher Produit</a>
        <a href="produit/stock_moins3.php" class="nav-link text-white">Stock</a>
      </div>
    </li>
    <li>
      <a class="nav-link text-white" data-bs-toggle="collapse" href="#demandeMenu"><i class="fas fa-list"></i> Demandes</a>
      <div class="collapse show ps-3" id="demandeMenu">
        <a href="produit/envoye.php" class="nav-link active text-white">Demandes envoyées</a>
        <a href="demande/gerer.php" class="nav-link text-white">Gérer</a>
      </div>
    </li>
    <li><a href="profil/monprofil.php" class="nav-link text-white"><i class="fas fa-user"></i> Profil</a></li>
    <li><a href="deconnexion.php" class="nav-link text-danger"><i class="fas fa-sign-out-alt"></i> Déconnexion</a></li>
  </ul>
  <hr>
  <div class="text-center">
    <small>Bonjour <strong><?php echo $d['username']; ?></strong> 👋</small>
  </div>
</div>

<!-- Content -->
<div class="content">
  <h1 class="mb-4">📋 Demandes envoyées</h1>

  <table class="table table-bordered table-striped">
    <thead class="table-primary">
      <tr>
        <th>ID</th>
        <th>Email</th>
        <th>Produits</th>
        <th>Total</th>
        <th>Statut</th>
        <th>Date demande</th>
        <th>Date validation</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php while($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= $row['id'] ?></td>
          <td><?= htmlspecialchars($row['email']) ?></td>
          <td>
            <?php
              $produits = json_decode($row['produits'], true);
              foreach($produits as $p){
                echo $p['nom']." x".$p['quantite']." (".$p['prix']." DH)<br>";
              }
            ?>
          </td>
          <td><?= $row['total'] ?> DH</td>
          <td>
            <?php if ($row['statut'] == 'en_attente'): ?>
              <span class="badge bg-warning">En attente</span>
            <?php else: ?>
              <span class="badge bg-success">Validée</span>
            <?php endif; ?>
          </td>
          <td><?= $row['date_demande'] ?></td>
          <td><?= $row['date_validation'] ?: '-' ?></td>
          <td>
            <a class="btn btn-sm btn-info" target="_blank"
               href="https://mail.google.com/mail/?view=cm&fs=1&to=<?= urlencode($row['email']) ?>">
               📧 Contacter
            </a>
            <?php if ($row['statut'] == 'en_attente'): ?>
              <a class="btn btn-sm btn-success"
                 href="envoye.php?valider=<?= $row['id'] ?>"
                 onclick="return confirm('Valider cette demande ?')">
                 ✅ Valider
              </a>
            <?php endif; ?>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
