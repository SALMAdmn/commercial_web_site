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

if (isset($_POST['valider_envoi'])) {
    // Décoder la liste produits depuis la demande
    $produits = json_decode($demande['produits'], true);
    if (!is_array($produits) || count($produits) === 0) {
        $error = "Données produits invalides.";
    } else {
        // 1) Vérification préliminaire du stock (pour message d'erreur utilisateur)
        $insuff = false;
        $insuff_msg = "";
        foreach ($produits as $p) {
            $pid = isset($p['produit_id']) ? intval($p['produit_id']) : (isset($p['id']) ? intval($p['id']) : 0);
            $qte = isset($p['quantite']) ? intval($p['quantite']) : 0;

            if ($pid <= 0 || $qte <= 0) {
                $insuff = true;
                $insuff_msg = "Données produit invalides (ID ou quantité manquante).";
                break;
            }

            $res = $conn->query("SELECT nom, stock FROM produits WHERE id = $pid");
            if (!$res || $res->num_rows === 0) {
                $insuff = true;
                $insuff_msg = "Produit introuvable (ID: $pid).";
                break;
            }
            $r = $res->fetch_assoc();
            if (intval($r['stock']) < $qte) {
                $insuff = true;
                $insuff_msg = "Stock insuffisant pour le produit : " . htmlspecialchars($r['nom']) .
                              " (stock disponible : " . intval($r['stock']) . ", demandé : $qte).";
                break;
            }
        }

        if ($insuff) {
            // Si stock insuffisant => on n'exécute rien d'autre
            $error = $insuff_msg;
        } else {
            // 2) Stock OK pour tous — vérifier la preuve (fichier)
            if (!isset($_FILES['preuve']) || $_FILES['preuve']['error'] !== 0) {
                $error = "Veuillez fournir une preuve pour valider.";
            } else {
                // Préparer l'upload
                $ext = pathinfo($_FILES['preuve']['name'], PATHINFO_EXTENSION);
                $filename = 'preuve_' . $id . '_' . time() . '.' . $ext;
                $upload_dir = __DIR__ . '/uploads/';
                if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);

                if (!move_uploaded_file($_FILES['preuve']['tmp_name'], $upload_dir . $filename)) {
                    $error = "Erreur lors de l'upload du fichier.";
                } else {
                    // 3) Début de la transaction pour mettre à jour stocks + demande
                    $conn->begin_transaction();
                    $ok = true;
                    $fail_pid = null;

                    $stmt = $conn->prepare("UPDATE produits SET stock = stock - ? WHERE id = ? AND stock >= ?");
                    if (!$stmt) {
                        $conn->rollback();
                        @unlink($upload_dir . $filename);
                        $error = "Erreur interne (préparation requête).";
                        $ok = false;
                    } else {
                        foreach ($produits as $p) {
                            $pid = isset($p['produit_id']) ? intval($p['produit_id']) : (isset($p['id']) ? intval($p['id']) : 0);
                            $qte = isset($p['quantite']) ? intval($p['quantite']) : 0;
                            $stmt->bind_param("iii", $qte, $pid, $qte);
                            $stmt->execute();
                            if ($stmt->affected_rows === 0) {
                                // Mise à jour n'a pas affecté de ligne => pas assez de stock (conflit)
                                $ok = false;
                                $fail_pid = $pid;
                                break;
                            }
                        }
                        $stmt->close();
                    }

                    if (!$ok) {
                        $conn->rollback();
                        // supprimer le fichier uploadé pour ne pas garder des fichiers orphelins
                        @unlink($upload_dir . $filename);
                        // récupérer nom/stock pour message si possible
                        if ($fail_pid) {
                            $resf = $conn->query("SELECT nom, stock FROM produits WHERE id = $fail_pid");
                            $rf = $resf ? $resf->fetch_assoc() : null;
                            $error = "Stock insuffisant pour le produit : " . ($rf['nom'] ?? "ID $fail_pid") .
                                     " (stock restant : " . ($rf['stock'] ?? '0') . "). La validation a été annulée.";
                        } else {
                            $error = $error ?? "Erreur lors de la mise à jour du stock. Validation annulée.";
                        }
                    } else {
                        // Tous les updates produits se sont bien passés → on met à jour la demande
                        $stmt2 = $conn->prepare("UPDATE demandes SET preuve = ?, statut = 'valide', date_validation = NOW() WHERE id = ?");
                        if ($stmt2) {
                            $stmt2->bind_param("si", $filename, $id);
                            $stmt2->execute();
                            $stmt2->close();
                            $conn->commit();

                            // Mettre à jour copie locale pour affichage
                            $demande['preuve'] = $filename;
                            $demande['statut'] = 'valide';
                            $demande['date_validation'] = date('Y-m-d H:i:s');
                            $success = "Preuve uploadée, demande validée et stock mis à jour.";
                        } else {
                            // problème improbable à cette étape => rollback et suppression fichier
                            $conn->rollback();
                            @unlink($upload_dir . $filename);
                            $error = "Erreur lors de la validation (requête update demandes).";
                        }
                    }
                } // end move_uploaded_file
            } // end preuve present
        } // end else stock ok
    } // end else produits array
} // end isset valider_envoi


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
$prix = isset($p['prix']) ? $p['prix'] : (isset($p['prix_total']) ? $p['prix_total'] : (isset($p['prix_unitaire']) ? $p['prix_unitaire'] * intval($p['quantite']) : 0));
echo "- ".htmlspecialchars($p['nom'])." x".intval($p['quantite'])." ($prix DH)<br>";
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
