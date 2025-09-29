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
$sql = "SELECT * FROM admin WHERE email='".$conn->real_escape_string($_SESSION['email'])."'";
$r = $conn->query($sql);
$admin = $r->fetch_assoc();

// --- Recherche ---
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
$filter_status = isset($_GET['status']) ? $_GET['status'] : '';

// --- Pagination ---
$limit = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// --- Compter le total ---
$count_sql = "SELECT COUNT(*) as total FROM demandes WHERE 1";
if($search != ''){
    if(is_numeric($search)){
        $count_sql .= " AND id = " . intval($search);
    } else {
        $count_sql .= " AND email LIKE '%$search%'";
    }
}
// if($filter_status == 'valide'){
//     $count_sql .= " AND statut='valide'";
// } elseif($filter_status == 'en_attente'){
//     $count_sql .= " AND statut='en_attente'";
// }

$count_result = $conn->query($count_sql);
$total_rows = $count_result->fetch_assoc()['total'];
$total_pages = ceil($total_rows / $limit);

// --- Récupérer les demandes ---
$sql = "SELECT * FROM demandes WHERE 1";
if($search != ''){
    if(is_numeric($search)){
        $sql .= " AND id = " . intval($search);
    } else {
        $sql .= " AND email LIKE '%$search%'";
    }
}
// if($filter_status == 'valide'){
//     $sql .= " AND statut='valide'";
// } elseif($filter_status == 'en_attente'){
//     $sql .= " AND statut='en_attente'";
// }
if($filter_status == 'valide'){
    $count_sql .= " AND statut='valide'";
    $sql .= " AND statut='valide'";
} elseif($filter_status == 'en_attente'){
    $count_sql .= " AND (statut='' OR statut IS NULL)";
    $sql .= " AND (statut='' OR statut IS NULL)";
}



$sql .= " ORDER BY date_demande DESC LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Demandes envoyées</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<style>
body { min-height: 100vh; display: flex; }
.sidebar { width: 250px; background: #194ed6ff; color: #fff; flex-shrink: 0; }
.sidebar a { color: #fff; text-decoration: none; }
.sidebar a:hover { background: #1040a6ff; color: #fff; }
.content { flex-grow: 1; padding: 20px; background: #f8f9fa; }
/* Uniformiser largeur boutons actions */
td form .btn,
td a.btn {
    min-width: 100px;  /* ajuste selon ton besoin */
    text-align: center;
}

</style>
</head>
<body>

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
<h2>Demandes envoyées</h2>

<form class="row g-2 mb-3" method="get">
  <div class="col-auto">
    <input type="text" name="search" class="form-control" placeholder="Recherche ID ou Email" value="<?= htmlspecialchars($search); ?>">
  </div>
  <div class="col-auto">
    <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i> Rechercher</button>
  </div>
  <div class="col-auto">
    <a href="?status=valide<?= $search != '' ? '&search='.urlencode($search) : ''; ?>" class="btn btn-success">Validées</a>
    <a href="?status=en_attente<?= $search != '' ? '&search='.urlencode($search) : ''; ?>" class="btn btn-warning">Non validées</a>
    <a href="envoye.php" class="btn btn-secondary">Tout</a>
</div>

</form>

<table class="table table-bordered table-hover align-middle">
<thead class="table-dark">
<tr>
<th>ID</th>
<th>Email</th>
<th>Produits</th>
<th>Total</th>
<th>Statut</th>
<th>Date demande</th>
<th>Date validation</th>
<th>Preuve</th>
<th>Actions</th>
</tr>
</thead>
<tbody>
<?php while($row = $result->fetch_assoc()): ?>
<tr>
<td><?= $row['id']; ?></td>
<td><?= htmlspecialchars($row['email']); ?></td>
<td>
<?php
$produits = json_decode($row['produits'], true);
if (is_array($produits)) {
    foreach ($produits as $p) {
        $nom = htmlspecialchars($p['nom']);
        $qte = intval($p['quantite']);
        $prix = isset($p['prix']) ? $p['prix'] : (isset($p['prix_total']) ? $p['prix_total'] : (isset($p['prix_unitaire']) ? $p['prix_unitaire'] * $qte : 0));
        echo "$nom x$qte ($prix DH)<br>";
    }
}
?>
</td>
<td><?= $row['total']; ?> DH</td>
<td>
<?php
$status = strtolower(trim($row['statut']));
if($status === 'valide' && !empty($row['preuve'])){
    echo '<span class="badge bg-success">Validée</span>';
} else {
    echo '<span class="badge bg-warning">En attente</span>';
}
?>

</td>
<td><?= $row['date_demande']; ?></td>
<td><?= $row['date_validation'] ?: '-'; ?></td>
<td>
<?php if(!empty($row['preuve'])): ?>
<a class="btn btn-sm btn-primary" href="uploads/<?= htmlspecialchars($row['preuve']); ?>" download>
📥 Télécharger reçu
</a>
<?php else: ?> - <?php endif; ?>
</td>
<td>
    <a class="btn btn-sm btn-info" target="_blank"
       href="https://mail.google.com/mail/?view=cm&fs=1&to=<?= urlencode($row['email']); ?>">
       📧 Contacter
    </a>

<?php if(empty($row['preuve'])): ?>
    <form method="post" action="validation.php?id=<?= $row['id']; ?>" style="display:inline;">
        <button type="submit" class="btn btn-sm btn-success">✅ Valider</button>
    </form>
<?php endif; ?>


</td>



</tr>
<?php endwhile; ?>
</tbody>
</table>

<nav>
<ul class="pagination">
<?php for($i = 1; $i <= $total_pages; $i++): ?>
<li class="page-item <?= $i==$page?'active':''; ?>">
    <a class="page-link"
       href="?page=<?= $i; ?><?= $search!=''?'&search='.urlencode($search):''; ?><?= $filter_status!=''?'&status='.$filter_status:''; ?>">
       <?= $i; ?>
    </a>
</li>
<?php endfor; ?>

</ul>
</nav>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
