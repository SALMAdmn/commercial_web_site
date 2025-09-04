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

/*// Connexion à la base de données
$bdd = new PDO('mysql:host=localhost;dbname=autohall', 'root', '');

// Fonction pour créer un ticket de service
function creerTicketService($val1, $val2, $val3, $val4, $val5, $val6, $val7, $val8, $val9, $val10) {
    global $bdd;
    $query = $bdd->prepare('INSERT INTO ticket(titre, description, demandeur, attribue, urgence, lieu, type, categorie, date_ouverture, temps_resolution) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
    $query->execute([$val1, $val2, $val3, $val4, $val5, $val6, $val7, $val8, $val9, $val10]);
    return $bdd->lastInsertId();
}*/
$message="";
$erreur ="";
$con=mysqli_connect('localhost','root','','autohall') or die('Impossible d\'accerder auserveur');
// Traitement du formulaire de création de tickets
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = $_POST['titre'];
    $description = $_POST['description'];
    $demandeur = $_SESSION['email'];
    $attribue = $_POST['attribue'];
    $statut = $_POST['statut'];
    $urgence = $_POST['urgence'];
    $lieu = $_POST['lieu'];
    $type = $_POST['type'];
    $categorie = $_POST['categorie'];
    $ouverture = $_POST['ouverture'];
    $resolution = $_POST['resolution'];
    $resolution = $_POST['resolution'];
    $modification=date('Y-m-d H:i:s');
if(isset($_POST['attribue']) and isset($_POST['titre']) and  isset($_POST['description'])){
if (!empty($_POST['attribue']) and !empty($_POST['titre']) and  !empty($_POST['description'])){
   
    $sql="INSERT INTO ticket(titre, description, demandeur, attribue, statut, urgence, lieu, type, categorie, modification,date_ouverture, temps_resolution) VALUES ('" .$titre . "','" .$description . "','" .$demandeur . "','" .$attribue  . "','" .$statut . "','" .$urgence . "','" .$lieu . "','" .$type . "','" .$categorie . "','" .$modification . "','" .$ouverture . "','" .$resolution . "')";

    if(mysqli_query($con,$sql)){
      $last=mysqli_insert_id($con);

if(isset($_FILES['fileUpload']) and $_FILES['fileUpload']['error'] === UPLOAD_ERR_OK){
$file_extension = strrchr($_FILES['fileUpload']['name'], ".");
$extensions_autorisees = array('.png', '.PNG');
if (in_array($file_extension, $extensions_autorisees)) {
$dossier = 'image';
if (!is_dir($dossier)) {
 mkdir($dossier);
}

$chemindest = $dossier.'/'.$last.'.png';
$chemintmp = $_FILES['fileUpload']['tmp_name'];
move_uploaded_file($chemintmp, $chemindest);

} 
elseif (!in_array($file_extension, $extensions_autorisees)) {
    $erreur .=  'les images .png qui sont autorisées'; 
   }
}

  $message="Ajout avec succés";} 
  else {
    $erreur .= "ajout echoué<br>";
  }  


   /* creerTicketService($titre, $description, $demandeur, $attribue, $urgence, $lieu, $type, $categorie, $ouverture, $resolution);*/

  }else{
    $erreur .= "remplir les champs obligatoires(*)<br>";
  }
}

}


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


 /* Cache le champ de fichier réel */
        input[type="file"] {
            display: none;
        }
        /* Style du bouton personnalisé */
        .custom-file-upload {
            display: inline-block;
            padding: 6px 12px;
            cursor: pointer;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
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
    <div class="sub-menu" style="display: block;">
       <a href="mestickets.php" class="sub-item">Mes tickets</a>
       <a href="touslesticket.php" class="sub-item">Tous les tickets</a>
       <a href="creerticket.php" class="sub-item" style="background-color: #001B60;">créer ticket</a>
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
      <header>Créer Ticket demandé par "<?php echo $_SESSION['email']; ?>"</header>
      <form action="#" method="POST" class="form" enctype="multipart/form-data">
        <div class="column">
         <div class="label">
           <label>Date d'ouverture</label>
           <label>temps de résolution</label>
          </div>
        
          <div>
          <div class="input-box">
            <input type="date" name="ouverture" required/>
          </div>
          <div class="input-box">
            <input type="date" name="resolution" required/>
          </div>
          </div>

          <div class="label">
          <label>Type</label>
          <label>Catégorie</label>
          </div>
          <div>
         <div class="select-box">
              <select name="type">
                <option value="incident">Incident</option>
            <option value="demande">REQUEST</option>
           </select>
         </div>
             <div class="select-box">
              <select name="categorie">
                <option value="">----------</option>
            <optgroup label="Root entity">
                <option value="Antivirus"> Antivirus </option>
                <option value="Appe-Employee"> App e-Employee </option>
                <option value="APPCC"> APPCC </option>
                <option value="AppGCMA"> AppGCMA </option>
                <option value="Auto_Naps"> Auto Naps </option>
                <option value="C_Compliance"> C. Compliance </option>
                <option value="Citrix"> Citrix </option>
                <option value="Consumable"> Consumable </option>
                <option value="Sales_agreement"> Sales agreement </option>
                <option value="CRM"> CRM </option>
                <option value="Devopps"> Devopps </option>
                <option value="Loyalty"> Loyalty </option>
                <option value="GDoc"> GDoc </option>
                <option value="GENERAFI"> GENERAFI </option>
                <option value="GestorNet"> GestorNet </option>
                <option value="GSM"> GSM </option>
                <option value="Internet"> Internet  </option>
                <option value="Intranet">Intranet </option>
                <option value="Telephone_line"> Telephone line </option>
                <option value="VPN_line"> VPN line </option>
                <option value="LOCPRO"> LOCPRO </option>
                <option value="System_Software"> System Software </option>
                <option value="Material"> Material </option>
                <option value="Messaging"> Messaging </option>
                <option value="Microsoft_Teams"> Microsoft Teams </option>
                <option value="Add"> Add </option>
                <option value="Moovapps"> Moovapps</option>
                <option value="Optimmo"> Optimmo </option>
                <option value="After-sales_service_tools"> After-sales service tools </option>
                <option value="PayRoll"> PayRoll </option>
                <option value="IP_Phone_extension"> IP Phone extension </option>
                <option value="Internal_telephone_extension"> Internal telephone extension </option>
                <option value="Data"> Data </option>
                <option value="Qalitel_Compare"> Qalitel Compare </option>
                <option value="Qalitel_Doc"> Qalitel Doc </option>
                <option value="WEB_MEETING"> WEB MEETING </option>
                <option value="Reporting"> Reporting </option>
                <option value="Add"> Add </option>
                <option value="Network"> Network </option>
                <option value="RIAPP"> RIAPP </option>
                <option value="Wise"> Wise </option>
                <option value="Website"> Sage Payroll & HR </option>
                <option value="SLV"> SLV </option>
                <option value="SMS"> SMS </option>
                <option value="Add"> Add </option>
                <option value="SRM"> SRM </option>
                <option value="VOXCO"> VOXCO </option>
                <option value="VPN_FortiClient"> VPN_FortiClient </option>
                <option value="WebEX"> WebEX </option>
                <option value="Wincar">Wincar  </option>
                <option value="Windows"> Windows </option>
            </optgroup>
              </select>
            </div>

        </div>
      </div>


<br>
<label>Statut</label>
              <div class="select-box">
              <select name="statut">
                <option value="encours">encours</option>
                <option value="terminé">terminé</option>
              </select>
              </div>
      
 
<br>
<?php

$sql1="select email,nom,action from admin where action='technicien' or action='stagiére'";

    $r1=mysqli_query($con,$sql1) or die('erreur exec recet');
   
?>


             <label>Attribué à (<span style="color: red">*</span>)</label>
              <div class="select-box">
              <select name="attribue">
                <option value="" hidden>------</option>
<?php
           while ($d= mysqli_fetch_array($r1)) {

      echo "<option value='".$d['email']."'>".$d['action']." ".$d['nom']."</option>";
}?>
              </select>
              </div>

 <div class="column">
         <div class="label">
           <label>Urgence</label>
          </div>
        
          <div>
             <div class="select-box">
              <select name="urgence">
                 <option value="trés élévée">trés élevée </option>
            <option value="élevée">élevée </option>
            <option value="moyenne">moyenne  </option>
            <option value="faible">faible  </option>
            <option value="trés faible ">trés faible  </option>
              </select>
            </div>
          </div>

          <div class="label">
          <label>Lieu</label>
          </div>
          <div>
             <div class="select-box">
              <select name="lieu">
                 <option value="">----------</option>
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

        </div>
      </div>


     
      <div class="input-box">
         <label for="titre">Titre (<span style="color: red">*</span>)</label>
        <input type="text"  name="titre" required></div>
      
       
        <div class="input-box">
           <label for="Description">Description (<span style="color: red">*</span>)</label>
        <input type="text" id="Description" name="description" required></div>
  
  <br>
      <div class="input-box">
      <label class="custom-file-upload">
            Choisir une image
            <input type="file" id="fileUpload" name="fileUpload" accept="image/*">
        </label>
        <span id="fileName">Aucune image choisi</span>
        <br><br>  
        </div>


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

 <script>
        const fileInput = document.getElementById('fileUpload');
        const fileName = document.getElementById('fileName');

        fileInput.addEventListener('change', function() {
            if (fileInput.files.length > 0) {
                fileName.textContent = fileInput.files[0].name;
            } else {
                fileName.textContent = 'Aucune image choisi';
            }
        });
    </script>




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

