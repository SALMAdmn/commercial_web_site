<?php
session_start();

if(!isset($_SESSION['email'])){

    header('location: admin.php');
    exit;
}
?>
<?php

$con=mysqli_connect('localhost','root','','autohall') or die('Impossible d\'accerder auserveur');
$sql1=$sql="select * from admin where email='".$_SESSION['email']."'";
    
    $r=mysqli_query($con,$sql1) or die('erreur exec recet');
    $d= mysqli_fetch_array($r);
    $_SESSION['action']=$d['action'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-with, initial-scale=1.0">


	<title> site autohall</title>
	<link rel="stylesheet"  href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

 <style>
/* -------- Sidebar (par défaut sur PC) -------- */
.side-bar {
  background: #00011A;
  backdrop-filter: blur(15px);
  width: 17%;
  height: 100vh;
  position: fixed;
  top: 0;
  left: 0;
  overflow-y: auto;
  transition: 0.6s ease;
  z-index: 1000;
}

.menu-btn {
  position: absolute;
  color: #fff;
  font-size: 35px;
  margin: 25px;
  cursor: pointer;
  z-index: 1001;
}

.entete {
  background: #fff;
  height: 80px;
}

.entete img {
  width: 80px;
  padding-left: 20px;
  padding-top: 10px;
}

.close-btn {
  position: absolute;
  color: #00011A;
  font-size: 23px;
  right: 0;
  margin: 15px;
  cursor: pointer;
  z-index: 1002;
}

.side-bar .menu {
  width: 100%;
  margin-top: 30px;
}

.side-bar .menu .item {
  position: relative;
  cursor: pointer;
}

.side-bar .menu .item a {
  color: #fff;
  font-size: 16px;
  text-decoration: none;
  display: block;
  padding: 5px 30px;
  line-height: 60px;
}

.side-bar .menu .item a:hover {
  background: #000430;
  transition: 0.3s ease;
}

.side-bar .menu .item i {
  margin-right: 15px;
}

.side-bar .menu .item a .dropdown {
  position: absolute;
  right: 0;
  margin: 20px;
  transition: 0.3s ease;
}

.side-bar .menu .item .sub-menu {
  background: #00011A;
  display: none;
}

.side-bar .menu .item .sub-menu a {
  line-height: 30px;
  font-size: 12px;
  padding-left: 80px;
}

.rotate {
  transform: rotate(90deg);
}

.text-box {
  width: 90%;
  color: #fff;
  position: absolute;
  top: 50%;
  left: 50%;
  margin-left: 5%;
  transform: translate(-50%, -50%);
  text-align: center;
  transition: 0.6s ease;
}

.on {
  background-color: #001B60;
}

/* -------- Responsive (Mobile & Tablette) -------- */
@media screen and (max-width: 768px) {
  .side-bar {
    width: 100%;     /* prend tout l’écran */
    left: -100%;     /* cachée par défaut */
  }

  .side-bar.active {
    left: 0;         /* affichée quand ouverte */
  }

  .menu-btn {
    position: fixed;
    top: 15px;
    left: 15px;
    font-size: 30px;
    margin: 0;
    z-index: 1001;
  }

  .entete img {
    width: 70px;
    padding-left: 15px;
    padding-top: 10px;
  }

  .text-box {
    position: relative;
    top: auto;
    left: auto;
    transform: none;
    margin: 20px auto;
    text-align: center;
  }
}

</style>



</head>
<body>
	<section class="header">
			
            <div class="menu-btn">
   <i class="fas fa-bars"></i>
</div>
<div class="side-bar">
    <header class="entete">
  <div class="close-btn">
     <i class="fas fa-times"></i>
  </div>
  <img src="images/logo.jpeg" alt="">
  
</header>


<div class="menu">
<div  class="on"><div class="item"><a href="acceuil.php"><i class="fas fa-home"></i>Acceuil</a></div></div>
   <?php 
       if ($_SESSION['action']=='administrateur' or $_SESSION['action']=='membre de service') { ?>
   <div class="item">
    <a class="sub-btn"><i class="fas fa-hands-helping"></i>Assistance<i class="fas fa-angle-right dropdown"></i></a>
    <div class="sub-menu">
       <a href="produit/admin_add_product.php" class="sub-item">Mes tickets</a>
       <a href="ticket/touslesticket.php" class="sub-item">tickets</a>
       <a href="ticket/creerticket.php" class="sub-item">créer ticket</a>
    </div>
  </div> <?php } elseif ($_SESSION['action']=='technicien' or $_SESSION['action']=='stagiére') { ?>
  <div class="item"><a href="ticket/ticketàfaire.php"><i class="fas fa-tasks"></i>Mes tickets</a></div>
  <?php } ?>


  <?php 
       if ($_SESSION['action']=='administrateur' or $_SESSION['action']=='membre de service') { ?> 

      <div class="item">
    <a class="sub-btn"><i class="fas fa-toolbox"></i>Parc<i class="fas fa-angle-right dropdown"></i></a>
    <div class="sub-menu">
       <a href="parc/afficherparc.php" class="sub-item">afficher</a>
       <a href="parc/ajouterparc.php" class="sub-item">ajouter</a>
    </div>
  </div>
   <?php } ?>

   
 <div class="item">
    <a class="sub-btn"><i class="fas fa-user"></i>Profil<i class="fas fa-angle-right dropdown"></i></a>
    <div class="sub-menu">
       <a href="profil/monprofil.php" class="sub-item">Mon Profil</a>
       <?php 
       if ($_SESSION['action']=='administrateur') {
         
        ?>
    <a href="profil/touslesprofiles.php" class="sub-item">tous les profiles</a>
  <?php } ?>
    </div>
  </div>

  
  <div class="item"><a href="deconnexion.php"><i class="fas fa-sign-out-alt"></i>Déconnecter</a></div>
</div>
</div>
<div class="text-box">
	<h1>Plateforme AUTO HALL</h1>
<h2>Bonjour <?php echo $d['nom']; ?></h2>
<h3>profil  -->  <?php echo $d['action']; ?></h3>
</div>

	</section>




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
       $('.text-box').css("margin-left", "5%");
       $('.menu-btn').css("visibility", "hidden");
     });
     //Active cancel button
     $('.close-btn').click(function(){
       $('.side-bar').addClass('active');
         $('.text-box').css("margin-left", "0%");
       $('.menu-btn').css("visibility", "visible");
     });
   });
</script>





</body>
</html>

