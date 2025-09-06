<?php
session_start();
$conn = new mysqli("localhost", "root", "", "inox_industrie");
if ($conn->connect_error) die("Connexion échouée : ".$conn->connect_error);

if (!isset($_SESSION['user_id'])) {
    echo "Vous devez être connecté !";
    exit();
}

$user_id = $_SESSION['user_id'];
$produit_id = intval($_POST['produit_id']);
$quantite   = max(1, intval($_POST['quantite']));

// Vérifier stock
$result = $conn->query("SELECT stock FROM produits WHERE id=$produit_id");
if ($row = $result->fetch_assoc()) {
    $stock = intval($row['stock']);
    if ($quantite > $stock) $quantite = $stock;

    // Ajouter ou mettre à jour le panier
    $check = $conn->query("SELECT * FROM paniers WHERE user_id=$user_id AND produit_id=$produit_id");
    if ($check->num_rows > 0) {
        $conn->query("UPDATE paniers SET quantite=$quantite WHERE user_id=$user_id AND produit_id=$produit_id");
    } else {
        $conn->query("INSERT INTO paniers(user_id, produit_id, quantite) VALUES($user_id, $produit_id, $quantite)");
    }
}

echo "Produit ajouté avec succès !";
?>
