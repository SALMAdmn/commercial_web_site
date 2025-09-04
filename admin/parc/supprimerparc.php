<?php
session_start();

if(!isset($_SESSION['email'])){

    header('location: admin.php');
    exit;
}
if($_SESSION['action']!='administrateur' and $_SESSION['action']!='membre de service'){

    header('location: admin.php');
    exit;
}
?>
<?php

if (isset($_GET['id'])) {
	$supp=$_GET['id']; 
$file='fichier/'.$_GET['id'].'.pdf';
if(file_exists($file)){
	unlink($file);
}
	$con=mysqli_connect('localhost','root','','autohall') or die('Impossible d\'accerder auserveur');
	$sql="delete from parc where nom='".$supp."'";
    $r=mysqli_query($con,$sql) or die('erreur exec recet');
   header('location: afficherparc.php');
}

?>