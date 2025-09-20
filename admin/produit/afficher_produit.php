<?php
session_start();
if(!isset($_SESSION['email'])){
    header('location: ../admin.php');
    exit;
}

$conn = new mysqli("localhost", "root", "", "inox_industrie");
if($conn->connect_error){
    die("Connexion échouée : " . $conn->connect_error);
}

// Récupération info admin
$sql = "SELECT * FROM admin WHERE email='".$_SESSION['email']."'";
$r = $conn->query($sql);
$admin = $r->fetch_assoc(); // Utiliser $admin pour cohérence

// --- Recherche ---
$search = "";
if(isset($_GET['search'])){
    $search = $conn->real_escape_string($_GET['search']);
}

// --- Pagination ---
$limit = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Compter le total
$count_sql = "SELECT COUNT(*) as total FROM produits WHERE nom LIKE '%$search%'";
$count_result = $conn->query($count_sql);
$total_rows = $count_result->fetch_assoc()['total'];
$total_pages = ceil($total_rows / $limit);

// Récupérer les produits
$sql = "SELECT * FROM produits WHERE nom LIKE '%$search%' LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Afficher Produits</title>
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
<h2>Liste des Produits</h2>

<!-- Barre de recherche -->
<form class="d-flex mb-3" method="get">
<input type="text" name="search" class="form-control me-2" placeholder="Rechercher un produit" value="<?= htmlspecialchars($search); ?>">
<button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
</form>

<!-- Tableau -->
<table class="table table-bordered table-hover align-middle">
<thead class="table-dark">
<tr>
<th>ID</th>
<th>Nom</th>
<th>Description</th>
<th>Prix</th>
<th>Stock</th>
<th>Catégorie</th>
<th>Image</th>
<th>Actions</th>
</tr>
</thead>
<tbody>
<?php while($row = $result->fetch_assoc()): ?>
    <?php
        $aujourdhui = date('Y-m-d');
        if (!empty($row['discount_percent']) &&
            $row['date_debut_discount'] <= $aujourdhui &&
            $row['date_fin_discount'] >= $aujourdhui
        ) {
            $prix_affiche = "<span class='text-decoration-line-through'>{$row['prix']} DH</span> <br>
                             <span class='text-danger fw-bold'>{$row['prix_promo']} DH ({$row['discount_percent']}%)</span>";
        } else {
            $prix_affiche = $row['prix'] . " DH";
        }
    ?>
<tr>
<td><?= $row['id']; ?></td>
<td><?= htmlspecialchars($row['nom']); ?></td>
<td><?= htmlspecialchars($row['description']); ?></td>
<td><?= $prix_affiche; ?></td>
<td><?= $row['stock']; ?></td>
<td><?= htmlspecialchars($row['categorie']); ?></td>
<td><img src="../../assets/IMG/<?= $row['image']; ?>" alt="" width="60"></td>
<td>
<a href="modifier_produit.php?id=<?= $row['id']; ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Modifier</a>
<a href="supprimer_produit.php?id=<?= $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Voulez-vous vraiment supprimer ce produit ?');"><i class="fas fa-trash"></i> Supprimer</a>
</td>
</tr>
<?php endwhile; ?>
</tbody>
</table>

<!-- Pagination -->
<nav>
<ul class="pagination">
<?php for($i = 1; $i <= $total_pages; $i++): ?>
<li class="page-item <?php if($i==$page) echo 'active'; ?>">
<a class="page-link" href="?page=<?= $i; ?>&search=<?= urlencode($search); ?>"><?= $i; ?></a>
</li>
<?php endfor; ?>
</ul>
</nav>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
