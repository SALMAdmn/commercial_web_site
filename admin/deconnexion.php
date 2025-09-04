<?php
session_start(); // Démarre la session

// Déconnexion de l'utilisateur
$_SESSION = array(); // Vide toutes les variables de session
session_destroy(); // Détruit la session

// Empêcher le retour en arrière
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

// Rediriger vers la page de connexion
header("Location: admin.php");
exit;
?>