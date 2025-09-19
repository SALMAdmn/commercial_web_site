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

// Messages
$success = "";
$error = "";

// --- Ajouter Admin ---
if(isset($_POST['add'])){
    $username = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql_add = "INSERT INTO admin (username,email,password) VALUES ('$username','$email','$password')";
    if($conn->query($sql_add)){
        $success = "Admin ajouté avec succès !";
    } else {
        $error = "Erreur : " . $conn->error;
    }
}

// --- Supprimer Admin ---
if(isset($_GET['delete'])){
    $id = intval($_GET['delete']);
    if($id != $admin['id']){
        $conn->query("DELETE FROM admin WHERE id=$id");
        $success = "Admin supprimé !";
    } else {
        $error = "Vous ne pouvez pas vous supprimer vous-même !";
    }
}

// --- Modifier Admin ---
if(isset($_POST['edit'])){
    $id = intval($_POST['id']);
    $username = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);
    $update_sql = "UPDATE admin SET username='$username', email='$email'";
    if(!empty($_POST['password'])){
        $update_sql .= ", password='".password_hash($_POST['password'], PASSWORD_DEFAULT)."'";
    }
    $update_sql .= " WHERE id=$id";
    if($conn->query($update_sql)){
        $success = "Admin modifié avec succès !";
    } else {
        $error = "Erreur : " . $conn->error;
    }
}

// Récupérer tous les admins
$result = $conn->query("SELECT * FROM admin ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Gérer Admins</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<style>
body { min-height: 100vh; display: flex; }
.sidebar { width: 250px; background: #194ed6ff; color: #fff; flex-shrink: 0; }
.sidebar a { color: #fff; text-decoration: none; }
.sidebar a:hover { background: #1040a6ff; color: #fff; }
.sidebar .submenu { padding-left: 15px; }
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
  </div>
</li>

<li><a href="envoye.php" class="nav-link text-white"><i class="fas fa-list"></i> Demandes</a></li>

<li>
  <a class="nav-link text-white" data-bs-toggle="collapse" href="#profilMenu"><i class="fas fa-user"></i> Profil</a>
  <div class="collapse ps-3" id="profilMenu">
    <a href="monprofil.php" class="nav-link text-white">Mon profil</a>
    <a href="admin_management.php" class="nav-link active bg-primary">Gérer Admins</a>
  </div>
</li>

<li><a href="../deconnexion.php" class="nav-link text-danger"><i class="fas fa-sign-out-alt"></i> Déconnexion</a></li>
</ul>
<hr>
<div class="text-center">
<small>Bonjour <strong><?= htmlspecialchars($admin['username']); ?></strong> 👋</small>
</div>
</div>

<!-- Contenu -->
<div class="content">
<h2 class="mb-4">Gestion des Admins</h2>

<?php if($success): ?><div class="alert alert-success"><?= $success ?></div><?php endif; ?>
<?php if($error): ?><div class="alert alert-danger"><?= $error ?></div><?php endif; ?>

<!-- Ajouter Admin -->
<div class="card mb-4">
  <div class="card-header">Ajouter un nouvel admin</div>
  <div class="card-body">
    <form method="post">
      <div class="row g-2">
        <div class="col-md-4"><input type="text" class="form-control" name="username" placeholder="Nom" required></div>
        <div class="col-md-4"><input type="email" class="form-control" name="email" placeholder="Email" required></div>
        <div class="col-md-3"><input type="password" class="form-control" name="password" placeholder="Mot de passe" required></div>
        <div class="col-md-1"><button type="submit" name="add" class="btn btn-primary w-100"><i class="fas fa-plus"></i></button></div>
      </div>
    </form>
  </div>
</div>

<!-- Liste Admins -->
<table class="table table-bordered table-hover align-middle">
<thead class="table-dark">
<tr>
<th>ID</th>
<th>Nom</th>
<th>Email</th>
<th>Actions</th>
</tr>
</thead>
<tbody>
<?php while($row = $result->fetch_assoc()): ?>
<tr>
<td><?= $row['id'] ?></td>
<td><?= htmlspecialchars($row['username']) ?></td>
<td><?= htmlspecialchars($row['email']) ?></td>
<td>
<!-- Modifier -->
<button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal<?= $row['id'] ?>"><i class="fas fa-edit"></i></button>
<!-- Supprimer -->
<?php if($row['id'] != $admin['id']): ?>
<a href="?delete=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer cet admin ?')"><i class="fas fa-trash"></i></a>
<?php endif; ?>
</td>
</tr>

<!-- Modal Modifier -->
<div class="modal fade" id="editModal<?= $row['id'] ?>" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="post">
      <div class="modal-header">
        <h5 class="modal-title">Modifier Admin</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="id" value="<?= $row['id'] ?>">
        <div class="mb-3">
          <label>Nom</label>
          <input type="text" class="form-control" name="username" value="<?= htmlspecialchars($row['username']) ?>" required>
        </div>
        <div class="mb-3">
          <label>Email</label>
          <input type="email" class="form-control" name="email" value="<?= htmlspecialchars($row['email']) ?>" required>
        </div>
        <div class="mb-3">
          <label>Mot de passe (laisser vide si inchangé)</label>
          <input type="password" class="form-control" name="password">
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" name="edit" class="btn btn-success">Enregistrer</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
      </div>
      </form>
    </div>
  </div>
</div>

<?php endwhile; ?>
</tbody>
</table>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
