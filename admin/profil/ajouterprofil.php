<?php
session_start();

if(!isset($_SESSION['email'])){

    header('location: admin.php');
    exit;
}
if($_SESSION['action']!='administrateur'){

    header('location: admin.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-with, initial-scale=1.0">


	<title> site autohall</title>
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
	
	*{
	margin: 0;
	padding: 0;
	font-family: 'poppins',sans-serif;
}
/*sidebar*/
.side-bar{
 background: #00011A;
 backdrop-filter: blur(15px);
 width: 17%;
 height: 100vh;
 position: fixed;
 top: 0;
 left: 0px;
 overflow-y: auto;
 transition: 0.6s ease;
 transition-property: left;
}
.menu-btn{
 position: absolute;
 color: black;
 font-size: 35px;
 margin: 25px;
 cursor: pointer;
}

.entete{
  background: #fff;
  height: 80px;
}
.entete img{
 width: 130px;
 padding-left: 40px;
 padding-top: 10px;
}



.close-btn{
 position: absolute;
color: #00011A;
 font-size: 23px;
 right:  0px;
 margin: 15px;
 cursor: pointer;
}
.side-bar .menu{
 width: 100%;
 margin-top: 30px;
}
.side-bar .menu .item{
 position: relative;
 cursor: pointer;
}
.side-bar .menu .item a{
 color: #fff;
 font-size: 16px;
 text-decoration: none;
 display: block;
 padding: 5px 30px;
 line-height: 60px;
}


.side-bar .menu .item a:hover{
background: #000430;
 transition: 0.3s ease;
}
.side-bar .menu .item i{
 margin-right: 15px;
}


.side-bar .menu .item a .dropdown{
 position: absolute;
 right: 0;
 margin: 20px;
 transition: 0.3s ease;
}
.side-bar .menu .item .sub-menu{
  background: #00011A;
 display: none;
}
.side-bar .menu .item .sub-menu a{
    line-height: 30px;
    font-size: 12px;
    padding-left: 80px;

}
.rotate{
 transform: rotate(90deg);
}
.side-bar.active{
    left: -300px;
}


.on{
background-color: #001B60;
}
/*form*/
body{
	min-height: 100vh;
	width: 100%;

}


.form-box{
  max-width: 400px;
  width: 100%;
  background: #fff;
  padding: 25px;
  box-shadow: 0 0 15px rgba(0.5, 0.5, 0.5, 0.5);


transition: 0.6s ease;
	position: relative;
	width: 400px;
	height: 550px;
	
	border-radius: 20px;
	backdrop-filter: blur(15px);
	display: flex;
	justify-content: center;
	align-items: center;
	margin-left: 35%;
	
}

h2{
	font-size: 2em;
	color: #333333;
	text-align: center;

}

.input-box{
	position: relative;
	margin: 20px 0;
	width: 350px;
	border-bottom: 2px solid grey;
}
.input-box label{
	position: absolute;
	top: 50%;
	left: 5px;
	transform: translateY(-50%);
	color: #333333;
	font-size: 1em;
	pointer-events: none;
	transition: .5s;

}
input:focus ~ label,
input:valid ~ label{
top: -5px;
}

select:focus ~ label,
select:valid ~ label{
top: -5px;
}

.input-box select{
	width: 300px;
	height: 50px;
	background: transparent;
	border: none;
	outline: none;
	size: 1em;
	padding: 0 35px 0 5px;
	color: black;
}

.input-box input{
	width: 300px;
	height: 50px;
	background: transparent;
	border: none;
	outline: none;
	size: 1em;
	padding: 0 35px 0 5px;
	color: black;
}


button{
	width: 100%;
	height: 40px;
	border-radius: 40px;
	background: grey;
	color: #fff;
	border: none;
	outline: none;
	cursor: pointer;
	font-size: 1em;
	font-weight: 600;
}

.message{
	background: #9fd2a1;
	padding: 5px 10px;
    text-align: center;
     color: #326b07;
    border-radius: 3px;
    font-synthesis: 14px;
    margin-top: 10px;
}
.erreur{
	background: pink;
	padding: 5px 10px;
    text-align: center;
    color: red;
    border-radius: 3px;
    font-synthesis: 14px;
    margin-top: 10px;
}
</style>



<?php 


$message="";
$erreur ="";
$con=mysqli_connect('localhost','root','','autohall') or die('Impossible d\'accerder auserveur');
if(isset($_POST['email']) and  isset($_POST['action']) and  isset($_POST['nom']) and  isset($_POST['mdp']) and  isset($_POST['confirm'])){
if (!empty($_POST['email']) and  !empty($_POST['action']) and  !empty($_POST['nom']) and  !empty($_POST['mdp']) and  !empty($_POST['confirm']) and ($_POST['mdp']==$_POST['confirm']) and (strlen($_POST['mdp'])>=8)){
	 $rw="select * from admin where email='".$_POST['email']."'";
        $rw1=mysqli_query($con,$rw) or die('erreur exec recet');
		if(mysqli_num_rows($rw1)==0){
		$sql1="INSERT INTO admin(email, nom, action, mdp) VALUES ('" .$_POST['email'] . "','" .$_POST['nom'] . "','" .$_POST['action'] . "','" .$_POST['mdp'] . "')";
		
		if(mysqli_query($con,$sql1)){
	$message="Ajout avec succés";}  
	else {
		$erreur .= "ajout echoué<br>";
	}      }
	else {
		$erreur .= "Email existe<br>";
	}


		} 
		elseif((strlen($_POST['mdp'])<8)){
    $erreur .= "au minimun 8 caractéres<br>";
  }

  elseif($_POST['mdp']!=$_POST['confirm']){
    $erreur .= "Erreur de confirmation<br>";
  }          }

?>	












</head>
<body>
 
              <div class="menu-btn">
   <i class="fas fa-bars"></i>
</div>
<div class="side-bar">
    <header class="entete">
  <div class="close-btn">
     <i class="fas fa-times"></i>
  </div>
  <img src="../images/logo.jpeg" alt="">
  
</header>


<div class="menu">
<div class="item"><a href="../acceuil.php"><i class="fas fa-home"></i>Acceuil</a></div>
  
   <div class="item">
    <a class="sub-btn"><i class="fas fa-hands-helping"></i>Assistance<i class="fas fa-angle-right dropdown"></i></a>
    <div class="sub-menu">
       <a href="../ticket/mestickets.php" class="sub-item">Mes tickets</a>
       <a href="../ticket/touslesticket.php" class="sub-item">Tous les tickets</a>
       <a href="../ticket/creerticket.php" class="sub-item">créer ticket</a>
    </div>
  </div>
    
<?php 
       if ($_SESSION['action']=='administrateur' or $_SESSION['action']=='membre de service') { ?><div class="item">
    <a class="sub-btn"><i class="fas fa-toolbox"></i>Parc<i class="fas fa-angle-right dropdown"></i></a>
    <div class="sub-menu">
       <a href="../parc/afficherparc.php" class="sub-item">afficher</a>
       <a href="../parc/ajouterparc.php" class="sub-item">ajouter</a>
    </div>
  </div>

   <?php } ?>
 <div class="item">
    <a class="sub-btn"><i class="fas fa-user"></i>Profil<i class="fas fa-angle-right dropdown"></i></a>
    <div class="sub-menu" style="display: block;">
       <a href="monprofil.php" class="sub-item">Mon Profil</a>
    <a href="touslesprofiles.php" class="sub-item" style="background-color: #001B60;">tous les profiles</a>
    </div>
  </div>
  <div class="item"><a href="../deconnexion.php"><i class="fas fa-sign-out-alt"></i>Déconnecter</a></div>
</div>
</div>

<br><br>
<br>

		<div class="form-box">
			<div class="form-value">
				<form action="" method="post">
					<h2>Ajouter Profil </h2>

					<div class="input-box">
						<select name="action" required>
							<option value=""></option>
							<option value="administrateur">administrateur</option>
							<option value="membre de service">membre de service</option>
							<option value="technicien">technicien</option>
							<option value="stagiére">stagiére</option>
						</select>
						<label for="">Action</label>
					</div>

					<div class="input-box">
						<input type="email" name="email" required>
						<label for="">Email</label>
					</div>
					
					<div class="input-box">
						<input type="text" name="nom" required>
						<label for="">Nom</label>
					</div>
					<div class="input-box">
						<input type="password" name="mdp" required>
						<label for="">Mot De Passe</label>
					</div>
					<div class="input-box">
						<input type="password" name="confirm" required>
						<label for="">Confirmer</label>
					</div>
				<br>
					<button type="submit" name="valid">ajouter</button>
					<?php if (!empty($message)){ ?>
	               <div class="message">
		           <strong><?php echo $message; ?></strong>
	               </div>
	               <?php } ?>
	               <?php if (!empty($erreur)){ ?>
	               <div class="erreur">
		           <strong><?php echo $erreur; ?></strong>
	               </div>
	               <?php } ?>
				</form>
			</div>


		</div>


<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
    
     $(document).ready(function(){
     //jquery for toggle sub menus
     $('.sub-btn').click(function(){
       $(this).next('.sub-menu').slideToggle();
       $(this).find('.dropdown').toggleClass('rotate');
     });
     //jquery for expand and collapse the sidebar
     $('.menu-btn').click(function(){
       $('.side-bar').removeClass('active');
       $('.form-box').css("margin-left", "35%");
       $('.menu-btn').css("visibility", "hidden");
     });
     //Active cancel button
     $('.close-btn').click(function(){
       $('.side-bar').addClass('active');
         $('.form-box').css("margin-left", "30%");
       $('.menu-btn').css("visibility", "visible");
     });
   });
</script>




</body>
</html>