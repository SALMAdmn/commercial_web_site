<?php
session_start();

if(isset($_SESSION['email'])){

    header('location: acceuil.php');
    exit;
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-with, initial-scale=1.0">


	<title> Inox_Industrie</title>
	<link rel="stylesheet"  href="log.css">
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">




<?php 

 
$erreur="";
$con=mysqli_connect('localhost','root','','autohall') or die('Impossible d\'accerder auserveur');
if(isset($_POST['email']) and  isset($_POST['pass'])){
if (!empty($_POST['email']) and !empty($_POST['pass'])){
		$sql1="select * from admin where email='".$_POST['email']."'";
		$sql2="select mdp from admin where email='".$_POST['email']."'";
		
		$r1=mysqli_query($con,$sql1) or die('erreur exec recet');
		$r2=mysqli_query($con,$sql2) or die('erreur exec recet');
		$data2 = mysqli_fetch_array($r2);
		if(mysqli_num_rows($r1)==0){
				$erreur = "email incorrecte.";
				}
        else{
        	
        	if($data2['mdp']==$_POST['pass']){
        		$_SESSION['email']=$_POST['email'];
      			header('location: acceuil.php');
      			exit;
			}
			
			else{ $erreur = "mot de passe incorrecte."; }
			}                                         }
else{ $erreur = "Remplir tout les champs."; }           }

?>	












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
						<label for="">Email</label>
					</div>
					
					<div class="input-box">
						<ion-icon name="lock-closed-outline"></ion-icon>
						<input type="password" name="pass" required>
						<label for="">Mot de passe</label>
					</div>
					
					<button type="submit" name="valid">Log in</button>
					<?php if (!empty($erreur)){ ?>
	               <div class="erreur">
		           <strong><?php echo $erreur; ?></strong>
	               </div>
	               <?php } ?>
				</form>
			</div>


		</div>
	</section>

<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>






</body>
</html>



