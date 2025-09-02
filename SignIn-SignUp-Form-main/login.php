<?php
$message = "";
$type = "";

// Connexion à la base de données
$servername = "localhost";
$username = "root"; 
$password = "";     
$dbname = "inox_industrie"; 

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

// Vérifier si le formulaire a bien été soumis
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $action = $_POST['action'];

    if ($action === "register") {
        // 🔹 INSCRIPTION
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Hash du mot de passe
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        // Vérifier si l'email existe déjà
        $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $message = "Cet email est déjà utilisé.";
            $type = "error";
        } else {
            // Insérer le nouvel utilisateur
            $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $email, $password_hash);

            if ($stmt->execute()) {
                $message = "Compte créé avec succès. Vous pouvez vous connecter.";
                $type = "success";
            } else {
                $message = "Erreur : " . $conn->error;
                $type = "error";
              }
        }
        $stmt->close();
    }

    elseif ($action === "login") {
        // 🔹 CONNEXION
        $username = $_POST['username'];
        $password = $_POST['password'];

        $stmt = $conn->prepare("SELECT * FROM users WHERE username=?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            // Vérifier le mot de passe
            if (password_verify($password, $user['password'])) {
                 // ✅ Connexion réussie → on démarre la session et on redirige
                session_start();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];

                header("Location: ../index.php");
            exit();
            } else {

                $message = "Mot de passe incorrect.";
                $type = "error";            }
        } else {

            $message = "Utilisateur introuvable.";
            $type = "error";        }
        $stmt->close();
    }
}

$conn->close();
?>




<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Connexion et inscription</title>
    <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
  <!-- Font Awesome -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="./style.css" />

  </head>
  <body>
    <div class="container">
      <div class="forms-container">
        <div class="signin-signup">
          <form action="login.php" class="sign-in-form" method="POST">
            <h2 class="title">Se connecter</h2>
            <div class="input-field">
              <i class="fas fa-user"></i>
              <input type="text" name="username" placeholder="Entrez votre nom " />
            </div>
            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input type="password" name="password" placeholder="Entrez votre mot de passe" />
            </div>
            <input type="hidden" name="action" value="login">
            <input type="submit" value="Se connecter" class="btn solid" />

            <p class="social-text">Ou rejoindre avec un compte social</p>
            <div class="social-media">
              <a href="https://web.facebook.com/profile.php?id=100076252924876&_rdc=1&_rdr#" class="social-icon">
                <i class="fab fa-facebook-f"></i>
              </a>
              <a href="https://web.facebook.com/profile.php?id=100076252924876&_rdc=1&_rdr#" class="social-icon">
                <i class="fab fa-twitter"></i>
              </a>
              <a href="https://www.google.com/search?q=inox+industrie+&sca_esv=9dd6fa6532a43e61&sxsrf=AE3TifP3g4cPiTSQDaJQ4-uT6cCBZ_6B4w%3A1755612704674&ei=IIakaIL0KIOXxc8P1bKxgAU&ved=0ahUKEwiChID9hpePAxWDS_EDHVVZDFAQ4dUDCBA&uact=5&oq=inox+industrie+&gs_lp=Egxnd3Mtd2l6LXNlcnAiD2lub3ggaW5kdXN0cmllIDIEECMYJzIEECMYJzIEECMYJzILEC4YgAQYxwEYrwEyBhAAGBYYHjIGEAAYFhgeMgYQABgWGB4yBhAAGBYYHjIGEAAYFhgeMgYQABgWGB5I9ApQ3QJY3QJwAXgBkAEAmAGMAaABjAGqAQMwLjG4AQPIAQD4AQGYAgKgAsIBwgIHECMYsAMYJ8ICChAAGLADGNYEGEeYAwCIBgGQBgmSBwMxLjGgB-cNsgcDMC4xuAeyAcIHBTMtMS4xyAcw&sclient=gws-wiz-serp" class="social-icon">
                <i class="fab fa-google"></i>
              </a>
              <a href="https://web.facebook.com/profile.php?id=100076252924876&_rdc=1&_rdr#" class="social-icon">
                <i class="fab fa-linkedin-in"></i>
              </a>
            </div>
          </form>


          <form action="login.php" class="sign-up-form" method="POST">
            <h2 class="title">Créer un compte</h2>
            <div class="input-field">
              <i class="fas fa-user"></i>
              <input type="text" name="username"placeholder="Entrez votre nom" />
            </div>
            <div class="input-field">
              <i class="fas fa-envelope"></i>
              <input type="email" name="email" placeholder="Entrez votre email" />
            </div>
            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input type="password" name="password" placeholder="Entrez votre mot de passe" />
            </div>
            <input type="hidden" name="action" value="register">
            <input type="submit" value="S’inscrire" class="btn solid" />

            <p class="social-text">Ou rejoindre avec un compte social</p>
            <div class="social-media">
              <a href="https://web.facebook.com/profile.php?id=100076252924876&_rdc=1&_rdr#" class="social-icon">
                <i class="fab fa-facebook-f"></i>
              </a>
              <a href="https://web.facebook.com/profile.php?id=100076252924876&_rdc=1&_rdr#" class="social-icon">
                <i class="fab fa-twitter"></i>
              </a>
              <a href="https://www.google.com/search?q=inox+industrie+&sca_esv=9dd6fa6532a43e61&sxsrf=AE3TifP3g4cPiTSQDaJQ4-uT6cCBZ_6B4w%3A1755612704674&ei=IIakaIL0KIOXxc8P1bKxgAU&ved=0ahUKEwiChID9hpePAxWDS_EDHVVZDFAQ4dUDCBA&uact=5&oq=inox+industrie+&gs_lp=Egxnd3Mtd2l6LXNlcnAiD2lub3ggaW5kdXN0cmllIDIEECMYJzIEECMYJzIEECMYJzILEC4YgAQYxwEYrwEyBhAAGBYYHjIGEAAYFhgeMgYQABgWGB4yBhAAGBYYHjIGEAAYFhgeMgYQABgWGB5I9ApQ3QJY3QJwAXgBkAEAmAGMAaABjAGqAQMwLjG4AQPIAQD4AQGYAgKgAsIBwgIHECMYsAMYJ8ICChAAGLADGNYEGEeYAwCIBgGQBgmSBwMxLjGgB-cNsgcDMC4xuAeyAcIHBTMtMS4xyAcw&sclient=gws-wiz-serp" class="social-icon">
                <i class="fab fa-google"></i>
              </a>
              <a href="https://web.facebook.com/profile.php?id=100076252924876&_rdc=1&_rdr#" class="social-icon">
                <i class="fab fa-linkedin-in"></i>
              </a>
            </div>
          </form>
        </div>
      </div>
      <div class="panels-container">

        <div class="panel left-panel">
            <div class="content">
                <h3>Première visite ?</h3>
                <p>Rejoignez-nous en créant un compte.</p>
                <button class="btn transparent" id="sign-up-btn">S’inscrire</button>
            </div>
            <img src="./img/log.svg" class="image" alt="">
        </div>

        <div class="panel right-panel">
            <div class="content">
                <h3>Déjà parmi nous ?</h3>
                <p>Connectez-vous pour accéder à votre compte et profiter de toutes nos fonctionnalités. </p>
                <button class="btn transparent" id="sign-in-btn">Connecter</button>
            </div>
            <img src="./img/register.svg" class="image" alt="">
        </div>
      </div>
    </div>

    <script src="./app.js"></script>





     <!-- ✅ Modale Bootstrap -->
  <div class="modal fade" id="messageModal" tabindex="-1" aria-labelledby="messageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header 
          <?php if($type==='success') echo 'bg-success text-white'; else echo 'bg-danger text-white'; ?>">
          <h5 class="modal-title" id="messageModalLabel">
            <?php echo ($type==='success') ? "Succès" : "Erreur"; ?>
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
        </div>
        <div class="modal-body">
          <?php echo $message; ?>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <?php if (!empty($message)): ?>
  <script>
    var myModal = new bootstrap.Modal(document.getElementById('messageModal'));
    myModal.show();
  </script>
  <?php endif; ?>
  </body>
</html>
