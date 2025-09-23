<?php 
session_start();

if(isset($_SESSION['email'])){
    header('location: acceuil.php');
    exit;
}

$erreur = "";

// Connexion à la bonne base
$con = mysqli_connect('localhost','root','','inox_industrie') or die("Impossible d'accéder au serveur");

if(isset($_POST['email']) && isset($_POST['pass'])){
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = $_POST['pass'];

    $sql = "SELECT * FROM admin WHERE email='$email'";
    $result = mysqli_query($con, $sql);

    if(mysqli_num_rows($result) == 0){
        $erreur = "Email incorrect.";
    } else {
        $admin = mysqli_fetch_assoc($result);

        // Vérification sécurisée
        if(password_verify($password, $admin['password'])){
            $_SESSION['email'] = $admin['email'];
            header('location: acceuil.php');
            exit;
        } else {
            $erreur = "Mot de passe incorrect.";
        }
    }
}



?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Inox_Industrie</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700&display=swap" rel="stylesheet">
<style>
	/* ======= Styles généraux ======= */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

body {
    /* Background couleur uni */
    background-color: #f2f2f2; /* gris clair */
    
    /* OU un dégradé si tu veux un effet plus joli */
    /* background: linear-gradient(to bottom right, #007bff, #00d4ff); */
    
    color: #333;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
}


/* ======= Section de la forme ======= */
.section {
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
}

/* ======= Formulaire ======= */
.form-box {
    background: rgba(255,255,255,0.9); /* fond blanc semi-transparent pour lisibilité */
    padding: 40px;
    border-radius: 12px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    width: 350px;
}

.form-value h2 {
    text-align: center;
    margin-bottom: 30px;
    color: #333;
}

/* ======= Input ======= */
.input-box {
    position: relative;
    margin-bottom: 25px;
}

.input-box input {
    width: 100%;
    padding: 10px 10px 10px 40px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 6px;
    outline: none;
    transition: 0.3s;
    color: #333; /* texte noir visible */
    background: #fff;
}

.input-box input:focus {
    border-color: #007bff;
}

.input-box label {
    position: absolute;
    top: 50%;
    left: 40px;
    transform: translateY(-50%);
    pointer-events: none;
    color: #aaa;
    transition: 0.3s;
}

.input-box input:focus + label,
.input-box input:not(:placeholder-shown) + label {
    top: -8px;
    left: 10px;
    font-size: 12px;
    color: #007bff;
}

/* ======= Icones ======= */
.input-box ion-icon {
    position: absolute;
    top: 50%;
    left: 10px;
    transform: translateY(-50%);
    font-size: 18px;
    color: #007bff;
}

/* ======= Bouton ======= */
button {
    width: 100%;
    padding: 12px;
    background: #007bff;
    border: none;
    border-radius: 6px;
    color: #fff;
    font-size: 16px;
    cursor: pointer;
    transition: 0.3s;
}

button:hover {
    background: #0056b3;
}

/* ======= Erreur ======= */
.erreur {
    margin-top: 15px;
    padding: 10px;
    background: #f8d7da;
    color: #721c24;
    border-radius: 6px;
    text-align: center;
    font-size: 14px;
}


</style>

</head>

<body>
<section class="section">
    <div class="form-box">
        <div class="form-value">
            <form action="" method="post">
                <h2>Se connecter</h2>
                <div class="input-box">
                    <ion-icon name="mail-outline"></ion-icon>
                    <input type="email" name="email" required>
                    <label>Email</label>
                </div>
                <div class="input-box">
                    <ion-icon name="lock-closed-outline"></ion-icon>
                    <input type="password" name="pass" required>
                    <label>Mot de passe</label>
                </div>
                <button type="submit" name="valid">Log in</button>
                <?php if(!empty($erreur)){ ?>
                    <div class="erreur"><strong><?php echo $erreur; ?></strong></div>
                <?php } ?>
            </form>
        </div>
    </div>
</section>

<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>
