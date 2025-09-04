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

	$con=mysqli_connect('localhost','root','','autohall') or die('Impossible d\'accerder auserveur');
	$sql="delete from ticket where id='".$supp."'";
    $r=mysqli_query($con,$sql) or die('erreur exec recet');


    $file='image/'.$_GET['id'].'.png';
if(file_exists($file)){
	unlink($file);
}

   header('location: mestickets.php');
}

?>