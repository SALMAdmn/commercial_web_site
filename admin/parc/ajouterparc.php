<?php
session_start();

if(!isset($_SESSION['email'])){

    header('location: ../admin.php');
    exit;
}
 if($_SESSION['action']!='administrateur' and $_SESSION['action']!='membre de service'){

    header('location: ../admin.php');
    exit;
}
?>

<?php
$message="";
$erreur ="";
$modification=date('Y-m-d H:i:s');

if( isset($_POST['type']) and isset($_POST['nom']) and isset($_POST['utilisateur']) and isset($_POST['lieu']) and isset($_POST['entreprise']) and isset($_POST['poste']) and isset($_POST['modéle']) and isset($_POST['marque']) and isset($_POST['livreur']) and isset($_POST['description'])){

  if(!empty($_POST['type']) and !empty($_POST['nom']) and !empty($_POST['utilisateur']) and !empty($_POST['lieu']) and !empty($_POST['entreprise']) and !empty($_POST['poste']) and !empty($_POST['modéle']) and !empty($_POST['marque']) and !empty($_POST['livreur']) and !empty($_POST['description']) and ($_FILES['document']['error']!==UPLOAD_ERR_NO_FILE)) {

$con=mysqli_connect('localhost','root','','autohall') or die('Impossible d\'accerder auserveur');
$sql1="select * from parc where nom='".$_POST['nom']."'";
$resultat=mysqli_query($con,$sql1) or die('erreur exec recet');
if(mysqli_num_rows($resultat)==0){
 $sql="INSERT INTO parc(type, nom, utilisateur, lieu, entreprise, poste, modéle, marque, livreur, description, modification) VALUES ('" .$_POST['type'] . "','" .$_POST['nom'] . "','" .$_POST['utilisateur'] . "','" .$_POST['lieu'] . "','" .$_POST['entreprise'] . "','" .$_POST['poste'] . "','" .$_POST['modéle'] . "','" .$_POST['marque'] . "','" .$_POST['livreur'] . "','" .$_POST['description'] . "','" .$modification . "')";
   
$file_extension = strrchr($_FILES['document']['name'], ".");
$extensions_autorisees = array('.pdf', '.PDF');
 
if (in_array($file_extension, $extensions_autorisees)) {
   if(mysqli_query($con,$sql)){
$dossier = 'fichier';
if (!is_dir($dossier)) {
 mkdir($dossier);
}
//var_dump($_FILES['document']['tmp_name'].'==>'.$_FILES['document']['name']);
$chemindest = $dossier.'/'.$_POST['nom'].'.pdf';
$chemintmp = $_FILES['document']['tmp_name'];
move_uploaded_file($chemintmp, $chemindest);

  $message="Ajout avec succés";
} 


  else {
    $erreur .= "ajout echoué<br>";
  }
}elseif (!in_array($file_extension, $extensions_autorisees)) {
    $erreur .=  'les fichier PDF qui sont autorisées'; 
   }
  

  }
    else  {
      $erreur .= $_POST['nom']." déja existe<br>";   
    } 

        
      
      
    }
else {
 $erreur .= "remplir tous les champs<br>";     
}

}

?>




























<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-with, initial-scale=1.0">


	<title> site autohall</title>
	<link rel="stylesheet"  href="../ticket/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

 <style>
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
 top: 0px;
 color: #00011A;
 font-size: 35px;
 margin: 25px;
 cursor: pointer;
 margin-right: 95%;
 

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

.container{
  margin-left: 15%;
  transition: 0.6s ease;
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
    <div class="sub-menu"  style="display: block;">
       <a href="afficherparc.php" class="sub-item">afficher</a>
       <a href="ajouterparc.php" class="sub-item" style="background-color: #001B60;">ajouter</a>
    </div>
  </div>

   <?php } ?>
  
 <div class="item">
    <a class="sub-btn"><i class="fas fa-user"></i>Profil<i class="fas fa-angle-right dropdown"></i></a>
    <div class="sub-menu">
       <a href="../profil/monprofil.php" class="sub-item">Mon Profil</a>
       <?php 
       if ($_SESSION['action']=='administrateur') {
         
        ?>
    <a href="../profil/touslesprofiles.php" class="sub-item">tous les profiles</a>
  <?php } ?>
    </div>
  </div>

  
  <div class="item"><a href="../deconnexion.php"><i class="fas fa-sign-out-alt"></i>Déconnecter</a></div>
</div>
</div>
 <section class="container">
      <header>Remplir la formule par "<?php echo $_SESSION['email']; ?>"</header>
      <form action="#" method="POST" class="form" enctype="multipart/form-data">
        <div class="column">
         <div class="label">
           <label>Type de produit</label>
           <label>Nom de produit</label>
           <label>Utilisateur</label>
           <label>Marque</label>
          </div>
        
          <div>
          <div class="select-box">
              <select name="type">
                  <option value="ordinateur">Ordinateur</option>
            <option value="moniteur">Moniteur</option>
            <option value="logiciels">Logiciels</option>
            <option value="materiels resseau">Matériels Réseau</option>
            <option value="peripheriques">Peripheriques</option>
            <option value="imprimantes">Imprimantes</option>
            <option value="cartouches">Cartouches</option>
            <option value="consommables">Consommables</option>
            <option value="telephones">Telephones</option>
            <option value="globales">Globales</option>
              </select>
            </div>
          <div class="input-box">
            <input type="text" name="nom" required/>
          </div>
          <div class="input-box">
            <input type="text" name="utilisateur" required/>
          </div>
          <div class="input-box">
            <input type="text" name="marque" required/>
          </div>
          </div>

           <div class="label">
           <label>Lieu</label>
           <label>Entreprise de vente</label>
           <label>Poste de travail</label>
           <label>Modéle identifié</label>
          </div>
        
          <div>
          <div class="select-box">
              <select name="lieu">
                  <option value=""  style="text-align: center;">----------</option>
        <optgroup label="Root entity">
            <option value="AH_Agadir_1">AH Agadir 1</option>
            <option value="Ah_Agadir_2">Ah Agadir 2</option>
            <option value="AH_Attaouia">AH Attaouia</option>
            <option value="AH_Beni Mellal">AH Beni Mellal</option>
            <option value="AH_Berkane">AH Berkane</option>
            <option value="AH_Chemaia">AH Chemaia</option>
            <option value="AH_Chemmaia">AH Chemmaia</option>
            <option value="AH_CHICHAQUA">AH CHICHAQUA</option>
            <option value="AH_Dakhla">AH Dakhla</option>
            <option value="AH_El_Hoceima">AH El Hoceima</option>
            <option value="AH_El_Jadida">AH El Jadida</option>
            <option value="AH_Eljadida">AH Eljadida</option>
            <option value="AH_Errachidia">AH Errachidia</option>
            <option value="AH_Fes">AH Fes</option>
            <option value="AH_Fes_1">AH Fes 1</option>
            <option value="AH_FES_2">AH FES 2</option>
            <option value="AH_Hoceima">AH Hoceima</option>
            <option value="AH_JORF">AH JORF</option>
            <option value="AH_Karia">AH Karia</option>
            <option value="AH_Kenitra">AH Kenitra</option>
            <option value="AH_KENITRA_2">AH KENITRA 2</option>
            <option value="AH_Lala_Yacout">AH Lala Yacout</option>
            <option value="AH_Lalla_Yacout">AH Lalla Yacout</option>
            <option value="AH_LLD">AH LLD</option>
            <option value="AH_Marrakech1">AH Marrakech 1</option>
            <option value="AH_Marrakech2">AH Marrakech 2</option>
            <option value="AH_Meknes1">AH Meknes 1</option>
            <option value="AH_Meknes2">AH Meknes 2</option>
            <option value="AHNADOR">AH NADOR</option>
            <option value="AH_OUJDA">AH OUJDA</option>
            <option value="AH_Oujda1">AH Oujda 1</option>
            <option value="AHOujda2">AH Oujda 2</option>
            <option value="AH_RABAT">AH RABAT</option>
            <option value="AH_Rabat1">AH Rabat 1</option>
            <option value="AH_Rabat2">AH Rabat 2</option>
            <option value="AH_Rabat1">AH Rabat1</option>
            <option value="AH_Rommani">AH Rommani</option>
            <option value="AH_safi1">AH safi 1</option>
            <option value="AH_Safi2">AH Safi 2</option>
            <option value="AH_SALE">AH SALE</option>
            <option value="AH_Settat">AH Settat</option>
            <option value="AH_Settat2">AH Settat 2</option>
            <option value="AH_Siège">AH Siège</option>
            <option value="AH_SOMMA">AH SOMMA</option>
            <option value="AH_Tanger1">AH Tanger 1</option>
            <option value="AH_Tanger2">AH Tanger 2</option>
            <option value="AH_TANGER1">AH TANGER1</option>
            <option value="AH_Tetouan">AH Tetouan</option>
            <option value="AH_Tiznit">AH Tiznit</option>
            <option value="AH_SETTAT">AH-SETTAT</option>
            <option value="AHTiznit">AHTiznit</option>
            <option value="AHVI">AHVI</option>
            <option value="DSI">DSI</option></optgroup>
            <optgroup label="New Headquarters">
            <option value="NS">NS</option>
            <option value="NS_AHVI">NS AHVI</option>
            <option value="NS_AM">NS AM</option>
            <option value="NS_DM">NS DM</option>
            <option value="NS_Nissan">NS Nissan</option>
            <option value="NS_Scama">NS Scama</option>
            <option value="NS_SM2A">NS SM2A</option>
            <option value="NS_SMVN">NS SMVN</option>
            <option value="NS_SOBERMA">NS SOBERMA</option>
            <option value="NS_SOMMA">NS SOMMA</option>
            <option value="NS_SUPPORT">NS SUPPORT</option>
            <option value="SCAMA_BEAUSITE">SCAMA BEAUSITE</option>
            <option value="Scama_MI_Ismail">Scama MI Ismail</option>
            <option value="Scama_Mly_Ismail">Scama Mly Ismail</option>
            <option value="SCAMASIEGE">SCAMA SIEGE</option>
            <option value="Settat">Settat</option>
            <option value="Siège">Siège</option>
            <option value="SMVN">SMVN</option>
            <option value="SNGU">SNGU</option>
            <option value="Somma_Settat">Somma Settat</option>
        </optgroup>
              </select>
            </div>
          <div class="input-box">
            <input type="text" name="entreprise" required/>
          </div>
          <div class="input-box">
            <input type="text" name="poste" required/>
          </div>
          <div class="input-box">
            <input type="text" name="modéle" required/>
          </div>
          </div>
        </div>

<div class="input-box">
         <label for="livreur">Livré par</label>
        <input type="text"  name="livreur" required></div>
     
 <div class="input-box">
           <label for="Description">Description</label>
        <input type="text" id="Description" name="description" required></div>


 <div class="input-box">
           <label for="document">Document connexe</label>
       <input type="file" id="document" name="document" accept=".pdf" required></div>






        <button type="submit" name="valid">Soumettre</button>

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
       $('.container').css("margin-left", "15%");
       $('.menu-btn').css("visibility", "hidden");
     });
     //Active cancel button
     $('.close-btn').click(function(){
       $('.side-bar').addClass('active');
         $('.container').css("margin-left", "0%");
       $('.menu-btn').css("visibility", "visible");
     });
   });
</script>





</body>
</html>

