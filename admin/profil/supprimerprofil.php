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
<?php

if (isset($_GET['id'])) {
	$supp=$_GET['id']; 

	$con=mysqli_connect('localhost','root','','autohall') or die('Impossible d\'accerder auserveur');
	$sql="delete from admin where email='".$supp."'";
    $r=mysqli_query($con,$sql) or die('erreur exec recet');
   header('location: touslesprofiles.php');
}

?>