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

if(isset($_GET['id'])){
    $id = (int) $_GET['id'];

    // Vérifier si le produit existe
    $check = $conn->query("SELECT * FROM produits WHERE id = $id");
    if($check->num_rows > 0){
        // Supprimer le produit
        $sql = "DELETE FROM produits WHERE id = $id";
        if($conn->query($sql) === TRUE){
            header("Location: afficher_produit.php?msg=supprime");
            exit;
        } else {
            echo "Erreur lors de la suppression : " . $conn->error;
        }
    } else {
        echo "Produit introuvable.";
    }
} else {
    echo "ID invalide.";
}
