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
$d = $r->fetch_assoc();

// --- Recherche ---
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';

// --- Filtre statut ---
$filter_status = isset($_GET['status']) ? $_GET['status'] : '';

// Construire la requête
$sql = "SELECT * FROM demandes WHERE 1 ";
if($search != ''){
    if(is_numeric($search)){
        $sql .= " AND id = " . intval($search);
    } else {
        $sql .= " AND email LIKE '%$search%'";
    }
}
if($filter_status == 'valide'){
    $sql .= " AND statut='valide' ";
} elseif($filter_status == 'en_attente'){
    $sql .= " AND statut='en_attente' ";
}
$sql .= " ORDER BY date_demande DESC";

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
</style>
</head>
<body>

<div class="sidebar d-flex flex-column p-3">
<h3 class="text-center mb-4">Inox_Industrie</h3>
<ul class="nav nav-pills flex-column mb-auto">
<li><a href="../acceuil.php" class="nav-link text-white"><i class="fas fa-home"></i> Accueil</a></li>
<li>
  <a class="nav-link text-white" data-bs-toggle="collapse" href="#demandeMenu"><i class="fas fa-list"></i> Demandes</a>
  <div class="collapse show ps-3" id="demandeMenu">
    <a href="envoye.php" class="nav-link active bg-primary">Demandes envoyées</a>
    <a href="gerer.php" class="nav-link text-white">Gérer</a>
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

<div class="content">
<h2 class="d-flex align-items-center justify-content-between">
    Demandes envoyées
</h2>

<!-- Barre de recherche et filtres -->
<form class="row g-2 mb-3" method="get">
  <div class="col-auto">
    <input type="text" name="search" class="form-control" placeholder="Recherche ID ou Email" value="<?php echo htmlspecialchars($search); ?>">
  </div>
  <div class="col-auto">
    <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i> Rechercher</button>
  </div>
  <div class="col-auto">
    <a href="?status=valide<?php echo $search != '' ? '&search='.urlencode($search) : ''; ?>" class="btn btn-success">Validées</a>
    <a href="?status=en_attente<?php echo $search != '' ? '&search='.urlencode($search) : ''; ?>" class="btn btn-warning">Non validées</a>
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
foreach($produits as $p){
    echo htmlspecialchars($p['nom'])." x".$p['quantite']." (".$p['prix']." DH)<br>";
}
?>
</td>
<td><?= $row['total']; ?> DH</td>
<td>
<?php if($row['statut']=='en_attente'): ?>
<span class="badge bg-warning">En attente</span>
<?php else: ?>
<span class="badge bg-success">Validée</span>
<?php endif; ?>
</td>
<td><?= $row['date_demande']; ?></td>
<td><?= $row['date_validation'] ?: '-'; ?></td>
<td>
<?php if(!empty($row['preuve'])): ?>
<a class="btn btn-sm btn-primary" href="uploads/<?= $row['preuve']; ?>" download>
📥 Télécharger reçu
</a>
<?php else: ?>
-
<?php endif; ?>
</td>
<td>
<a class="btn btn-sm btn-info" target="_blank"
   href="https://mail.google.com/mail/?view=cm&fs=1&to=<?= urlencode($row['email']); ?>">
   📧 Contacter
</a>

<?php if($row['statut']=='en_attente'): ?>
<a class="btn btn-sm btn-success"
   href="validation.php?id=<?= $row['id']; ?>">
   ✅ Valider
</a>
<?php endif; ?>
</td>
</tr>
<?php endwhile; ?>
</tbody>
</table>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
