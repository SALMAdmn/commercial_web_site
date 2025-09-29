<?php 
session_start();
$conn = new mysqli("localhost", "root", "", "inox_industrie");
if ($conn->connect_error) die("Connexion échouée : " . $conn->connect_error);

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
if (!$user_id) {
    header("Location: SignIn-SignUp-Form-main/login.php");
    exit;
}

if (isset($_POST['valider_panier'])) {

    // Récupérer tous les produits du panier
    $result = $conn->query("SELECT p.id, p.nom, p.prix, p.stock, pa.quantite 
                             FROM paniers pa 
                             JOIN produits p ON pa.produit_id = p.id 
                             WHERE pa.user_id=$user_id");

    if ($result->num_rows > 0) {
        $produits_list = [];
        $total = 0;

        while ($row = $result->fetch_assoc()) {
            $produit_id = intval($row['id']);
            $quantite = intval($row['quantite']);
            $prix_unitaire = floatval($row['prix']);
            $nom_produit = $row['nom'];

            if ($quantite > $row['stock']) $quantite = $row['stock'];

            $total += $prix_unitaire * $quantite;

            $produits_list[] = [
                "produit_id" => $produit_id,
                "nom" => $nom_produit,
                "quantite" => $quantite,
                "prix_unitaire" => $prix_unitaire
            ];
        }

        // Récupérer email de l'utilisateur
        $user_result = $conn->query("SELECT email FROM users WHERE id=$user_id");
        $email = ($user_row = $user_result->fetch_assoc()) ? $user_row['email'] : "";

        // Enregistrer dans demandes
        $stmt = $conn->prepare("INSERT INTO demandes (email, produits, total, statut, date_demande) VALUES (?, ?, ?, ?, NOW())");
        $statut = "En attente";
        $produits_json = json_encode($produits_list);
        $stmt->bind_param("ssds", $email, $produits_json, $total, $statut);
        $stmt->execute();

        // Vider le panier
        $conn->query("DELETE FROM paniers WHERE user_id=$user_id");

        $_SESSION['demande_validee'] = true;
    }
}

// Redirection vers panier
header("Location: panier.php");
exit;
