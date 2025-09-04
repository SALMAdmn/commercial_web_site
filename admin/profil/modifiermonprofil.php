<?php
session_start();

if(!isset($_SESSION['email'])){

    header('location: admin.php');
    exit;
}
?>
<?php 
$message="";
$erreur ="";
$con=mysqli_connect('localhost','root','','autohall') or die('Impossible d\'accerder auserveur');
if (isset($_POST['nom']) and isset($_POST['mdp']) and isset($_POST['confirm'])){
	if (!empty($_POST['nom']) and !empty($_POST['mdp']) and  !empty($_POST['confirm']) and ($_POST['mdp']==$_POST['confirm']) and (strlen($_POST['mdp'])>=8)){
	$con=mysqli_connect('localhost','root','','autohall') or die('Impossible d\'accerder auserveur');
	$sql="UPDATE admin
	SET nom ='".$_POST['nom']."', mdp ='".$_POST['mdp']."'
	where email ='".$_SESSION['email']."' ";
   if(mysqli_query($con,$sql)){
   	$message="Mot de passe modifié";
   } else {
    $erreur .= "echec de modification<br>";
  }      }
  elseif((strlen($_POST['mdp'])<8)){
    $erreur .= "au minimun 8 caractéres<br>";
  }

  elseif($_POST['mdp']!=$_POST['confirm']){
    $erreur .= "Erreur de confirmation<br>";
  }


}
 


?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-with, initial-scale=1.0">


	<title>  site autohall</title>
	
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">


<style>
* {
  margin: 0;
  padding: 0;
  font-family: 'Poppins', sans-serif;
}
/*modifier style*/
.confirmer{
    display: inline-block;
    text-decoration: none;
    color: #fff;
    border: 1px solid #fff;
    border-radius: 5px;
    padding: 12px 34px;
    margin: 15px 15px;
    font-size: 26px; 
    background: #001B60;
    position: relative;
    cursor: pointer;
}
.confirmer:hover{
    border: 1px solid #001B60;
    background: #001B60;
    transition: 1s; 

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
/*liste*/
	.table{
	min-height: 100vh;
	width: 100%;
	background-color: #fff;
}

table, th, td{
	/*border: 1px solid;*/
	border-collapse: collapse;
}
.tableau{ 
transition: 0.6s ease;
margin-top: 7%;
    margin-left: 30%;
	display: inline-block;
    padding: 40px 130px; 
	width: 30%;

}

.tableau th,td{
	padding: 15px;
	text-align: left;
}


tr:nth-child(even) {
	background-color: #f2f2f2;
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
  <?php 
       if ($_SESSION['action']=='administrateur' or $_SESSION['action']=='membre de service') { ?>
   <div class="item">
    <a class="sub-btn"><i class="fas fa-hands-helping"></i>Assistance<i class="fas fa-angle-right dropdown"></i></a>
    <div class="sub-menu">
       <a href="../ticket/mestickets.php" class="sub-item">Mes tickets</a>
       <a href="../ticket/touslesticket.php" class="sub-item">Tous les tickets</a>
       <a href="../ticket/creerticket.php" class="sub-item">créer ticket</a>
    </div>
  </div> <?php } elseif ($_SESSION['action']=='technicien' or $_SESSION['action']=='stagiére') { ?>
  <div class="item"><a href="../ticket/ticketàfaire.php"><i class="fas fa-tasks"></i>Mes tickets</a></div>
  <?php } ?>
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
       <a href="monprofil.php" class="sub-item" style="background-color: #001B60;">Mon Profil</a>
     <?php 
       if ($_SESSION['action']=='administrateur') {
         
        ?>
    <a href="touslesprofiles.php" class="sub-item">tous les profiles</a>
  <?php } ?>
    </div>
  </div>
  <div class="item"><a href="../deconnexion.php"><i class="fas fa-sign-out-alt"></i>Déconnecter</a></div>
</div>
</div>
<?php 

$con=mysqli_connect('localhost','root','','autohall') or die('Impossible d\'accerder auserveur');



$sql="select * from admin where email='".$_SESSION['email']."'";
$r=mysqli_query($con,$sql) or die('erreur exec recet');
$d=mysqli_fetch_array($r);
?>
<section class="table">
<div class="tableau">
	<h1>Mon Profil</h1>
	<form action='' method='post'>
<table border="1" width="100%">
	<thead> 
	
    </thead>
    <tbody>        

<?php 
    echo "<tr>";
    echo "<th>";
	echo "Email";
	echo "</th >";
	echo "<td>";
	echo $d['email'];
	echo "</td>";
	echo "</tr>";


  echo "<tr>";
    echo "<th>";
  echo "Action";
  echo "</th >";
  echo "<td>";
  echo $d['action'];
  echo "</td >";
  echo "</tr>";



     echo "<tr>";
    echo "<th>";
	echo "Nom";
	echo "</th >";
	echo "<td>";
	echo "<input type='' name='nom' value='".$d['nom']."'>";
	echo "</td >";
	echo "</tr>";


	echo "<tr>";
    echo "<th>";
	echo "Mot De Passe";
	echo "</th >";
	echo "<td>";
	echo "<input type='password' name='mdp'>";
	echo "</td >";
	echo "</tr>";


	echo "<tr>";
    echo "<th>";
	echo "Confirmer";
	echo "</th >";
	echo "<td>";
	echo "<input type='password' name='confirm'>";
	echo "</td >";
	echo "</tr>";
    
	?>

    </tbody>
</table>
<button type="submit" name="valid" class="confirmer">Confirmer</button> 
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
       $('.tableau').css("margin-left", "30%");
       $('.menu-btn').css("visibility", "hidden");
     });
     //Active cancel button
     $('.close-btn').click(function(){
       $('.side-bar').addClass('active');
         $('.tableau').css("margin-left", "20%");
       $('.menu-btn').css("visibility", "visible");
     });
   });
</script>







</body>
</html>
