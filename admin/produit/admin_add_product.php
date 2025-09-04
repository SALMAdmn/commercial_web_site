<?php
session_start();

// Connexion à la base de données
$conn = new mysqli("localhost", "root", "", "inox_industrie");
if($conn->connect_error){
    die("Connexion échouée : " . $conn->connect_error);
}

// Traitement du formulaire
if(isset($_POST['submit'])){
    // Sécurisation des données
    $nom = $conn->real_escape_string($_POST['nom']);
    $description = $conn->real_escape_string($_POST['description']);
    $prix = $conn->real_escape_string($_POST['prix']);
    $stock = $conn->real_escape_string($_POST['stock']);
    $categorie = $conn->real_escape_string($_POST['categorie']);

    // Upload image
    $image = basename($_FILES['image']['name']);
    // Remplacement des caractères spéciaux
    $image = preg_replace("/[^a-zA-Z0-9.-]/", "_", $image);
    $target = "../../assets/IMG/".$image; // chemin relatif selon ton projet

    if(move_uploaded_file($_FILES['image']['tmp_name'], $target)){
        // Insertion dans la base de données
        $sql = "INSERT INTO produits (nom, description, image, prix, stock, categorie)
                VALUES ('$nom','$description','$image','$prix','$stock','$categorie')";

        if($conn->query($sql) === TRUE){
            $message = "Produit ajouté avec succès !";
        } else {
            $message = "Erreur SQL : " . $conn->error;
        }
    } else {
        $message = "Erreur lors de l'upload de l'image.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un produit - Admin</title>
    <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
    <style>
        body { padding: 20px; }
        input, textarea, select { width: 100%; margin-bottom: 10px; padding: 5px; }
        .btn { padding: 8px 15px; }
        .message { margin-bottom: 15px; }
    </style>
</head>
<body>

<h2>Ajouter un produit</h2>

<?php if(isset($message)) echo "<div class='message'>$message</div>"; ?>

<form method="POST" enctype="multipart/form-data">
    <label>Nom du produit :</label>
    <input type="text" name="nom" required>

    <label>Description :</label>
    <textarea name="description" rows="4" required></textarea>

    <label>Prix :</label>
    <input type="text" name="prix" required>

    <label>Stock :</label>
    <input type="number" name="stock" required>

    <label>Catégorie :</label>
    <select name="categorie" required>
        <option value="">--Sélectionnez une catégorie--</option>
        <option value="Alimentaire">1️⃣ Alimentaire</option>
        <option value="Construction">2️⃣ Construction</option>
        <option value="Transport">3️⃣ Transport</option>
        <option value="Énergie & Chimie">4️⃣ Énergie & Chimie</option>
        <option value="Domestique">5️⃣ Domestique</option>
        <option value="Médical">6️⃣ Médical</option>
    </select>

    <label>Image :</label>
    <input type="file" name="image" accept="image/*" required>

    <button type="submit" name="submit" class="btn btn-primary">Ajouter produit</button>
</form>

</body>
</html>
