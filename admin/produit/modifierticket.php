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
$con=mysqli_connect('localhost','root','','autohall') or die('Impossible d\'accerder auserveur');
$modification=date('Y-m-d H:i:s');
if(isset($_POST['attribue']) and isset($_POST['titre']) and  isset($_POST['description'])){
if (!empty($_POST['attribue']) and !empty($_POST['titre']) and  !empty($_POST['description'])){
   $sql="UPDATE ticket
  SET titre ='".$_POST['titre']."', description ='".$_POST['description']."', attribue ='".$_POST['attribue']."', statut ='".$_POST['statut']."', urgence ='".$_POST['urgence']."', lieu ='".$_POST['lieu']."', type ='".$_POST['type']."', categorie ='".$_POST['categorie']."', date_ouverture ='".$_POST['date_ouverture']."', temps_resolution ='".$_POST['temps_resolution']."', modification ='".$modification."'
  where id ='".$_GET['id']."' ";

if(mysqli_query($con,$sql)){
  if(isset($_FILES['fileUpload']) and $_FILES['fileUpload']['error'] === UPLOAD_ERR_OK){
$file_extension = strrchr($_FILES['fileUpload']['name'], ".");
$extensions_autorisees = array('.png', '.PNG');
if (in_array($file_extension, $extensions_autorisees)) {
$dossier = 'image';
if (!is_dir($dossier)) {
 mkdir($dossier);
}

$chemindest = $dossier.'/'.$_GET['id'].'.png';
$chemintmp = $_FILES['fileUpload']['tmp_name'];
move_uploaded_file($chemintmp, $chemindest);

} 
elseif (!in_array($file_extension, $extensions_autorisees)) {
    $erreur .=  'les images .png qui sont autorisées'; 
   }
}

    $message="modification avec succés";
   } else {
    $erreur .= "echec de modification<br>";
  }     
}}
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
    /*position: relative;*/
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
margin-top: 3%;
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
select,input{
 
  width: 90%;
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
    <div class="sub-menu"  style="display: block;">
      <a href="mestickets.php" class="sub-item" style="background-color: #001B60;">Mes tickets</a>
       <a href="touslesticket.php" class="sub-item">Tous les tickets</a>
       <a href="creerticket.php" class="sub-item">créer ticket</a>
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
<?php 

$con=mysqli_connect('localhost','root','','autohall') or die('Impossible d\'accerder auserveur');



$sql="select * from ticket where id='".$_GET['id']."'";
$r=mysqli_query($con,$sql) or die('erreur exec recet');
$d=mysqli_fetch_array($r);
?>
<section class="table">
<div class="tableau">
  <h1>ticket <?php echo $d['id']; ?></h1>
  <br>
  <form action='' method='post' enctype="multipart/form-data">
<table border="1" width="100%">
  <thead> 
  
    </thead>
    <tbody>        

<?php 
    echo "<tr>";
    echo "<th>";
  echo "Titre";
  echo "</th >";
  echo "<td>";
  echo "<input type='text' name='titre' value='".$d['titre']."'>";
  echo "</td>";
  echo "</tr>";




  echo "<tr>";
    echo "<th>";
  echo "Description";
  echo "</th >";
  echo "<td>";
  echo "<input type='text' name='description' value='".$d['description']."'>";
  echo "</td >";
  echo "</tr>";


echo "<tr>";
    echo "<th>";
  echo "Attribué à";
  echo "</th >";
  echo "<td>";


$sql1="select email,nom,action from admin where action='technicien' or action='stagiére'";
 $r1=mysqli_query($con,$sql1) or die('erreur exec recet');

 $sql2="select nom,action from admin where email='".$d['attribue']."'";
 $r2=mysqli_query($con,$sql2) or die('erreur exec recet');
$d2= mysqli_fetch_array($r2);


             
            echo "<select name='attribue'>
                <option value='".$d['attribue']."' hidden>".$d2['action']." ".$d2['nom']."</option>";
           while ($d1= mysqli_fetch_array($r1)) {
      echo "<option value='".$d1['email']."'>".$d1['action']." ".$d1['nom']."</option>";
}
              echo "</select>";
  echo "</td >";
  echo "</tr>";

echo "<tr>";
    echo "<th>";
  echo "Statut";
  echo "</th >";
  echo "<td>";
  echo "<select name='statut'>
                <option value='".$d['statut']."' hidden>".$d['statut']." </option>
                <option value='encours'>encours</option>
                <option value='terminé'>terminé</option>
              </select>";
  echo "</td >";
  echo "</tr>";




echo "<tr>";
    echo "<th>";
  echo "Urgence";
  echo "</th >";
  echo "<td>";
  echo "<select name='urgence'>
            <option value='".$d['urgence']."' hidden>".$d['urgence']." </option>
            <option value='trés élévée'>trés élevée </option>
            <option value='élevée'>élevée </option>
            <option value='moyenne'>moyenne  </option>
            <option value='faible'>faible  </option>
            <option value='trés faible '>trés faible  </option>
              </select>";
  echo "</td >";
  echo "</tr>";

  echo "<tr>";
    echo "<th>";
  echo "Lieu";
  echo "</th >";
  echo "<td>";
  echo "<select name='lieu'>
            <option value='".$d['lieu']."' hidden>".$d['lieu']." </option>
            <optgroup label='Root entity'>
                <option value='AH_Agadir_1'>AH Agadir 1</option>
                <option value='Ah_Agadir_2'>Ah Agadir 2</option>
                <option value='AH_Attaouia'>AH Attaouia</option>
                <option value='AH_Beni Mellal'>AH Beni Mellal</option>
                <option value='AH_Berkane'>AH Berkane</option>
                <option value='AH_Chemaia'>AH Chemaia</option>
                <option value='AH_Chemmaia'>AH Chemmaia</option>
                <option value='AH_CHICHAQUA'>AH CHICHAQUA</option>
                <option value='AH_Dakhla'>AH Dakhla</option>
                <option value='AH_El_Hoceima'>AH El Hoceima</option>
                <option value='AH_El_Jadida'>AH El Jadida</option>
                <option value='AH_Eljadida'>AH Eljadida</option>
                <option value='AH_Errachidia'>AH Errachidia</option>
                <option value='AH_Fes'>AH Fes</option>
                <option value='AH_Fes_1'>AH Fes 1</option>
                <option value='AH_FES_2'>AH FES 2</option>
                <option value='AH_Hoceima'>AH Hoceima</option>
                <option value='AH_JORF'>AH JORF</option>
                <option value='AH_Karia'>AH Karia</option>
                <option value='AH_Kenitra'>AH Kenitra</option>
                <option value='AH_KENITRA_2'>AH KENITRA 2</option>
                <option value='AH_Lala_Yacout'>AH Lala Yacout</option>
                <option value='AH_Lalla_Yacout'>AH Lalla Yacout</option>
                <option value='AH_LLD'>AH LLD</option>
                <option value='AH_Marrakech1'>AH Marrakech 1</option>
                <option value='AH_Marrakech2'>AH Marrakech 2</option>
                <option value='AH_Meknes1'>AH Meknes 1</option>
                <option value='AH_Meknes2'>AH Meknes 2</option>
                <option value='AHNADOR'>AH NADOR</option>
                <option value='AH_OUJDA'>AH OUJDA</option>
                <option value='AH_Oujda1'>AH Oujda 1</option>
                <option value='AHOujda2'>AH Oujda 2</option>
                <option value='AH_RABAT'>AH RABAT</option>
                <option value='AH_Rabat1'>AH Rabat 1</option>
                <option value='AH_Rabat2'>AH Rabat 2</option>
                <option value='AH_Rabat1'>AH Rabat1</option>
                <option value='AH_Rommani'>AH Rommani</option>
                <option value='AH_safi1'>AH safi 1</option>
                <option value='AH_Safi2'>AH Safi 2</option>
                <option value='AH_SALE'>AH SALE</option>
                <option value='AH_Settat'>AH Settat</option>
                <option value='AH_Settat2'>AH Settat 2</option>
                <option value='AH_Siège'>AH Siège</option>
                <option value='AH_SOMMA'>AH SOMMA</option>
                <option value='AH_Tanger1'>AH Tanger 1</option>
                <option value='AH_Tanger2'>AH Tanger 2</option>
                <option value='AH_TANGER1'>AH TANGER1</option>
                <option value='AH_Tetouan'>AH Tetouan</option>
                <option value='AH_Tiznit'>AH Tiznit</option>
                <option value='AH_SETTAT'>AH-SETTAT</option>
                <option value='AHTiznit'>AHTiznit</option>
                <option value='AHVI'>AHVI</option>
                <option value='DSI'>DSI</option></optgroup>
                <optgroup label='New Headquarters'>
                <option value='NS'>NS</option>
                <option value='NS_AHVI'>NS AHVI</option>
                <option value='NS_AM'>NS AM</option>
                <option value='NS_DM'>NS DM</option>
                <option value='NS_Nissan'>NS Nissan</option>
                <option value='NS_Scama'>NS Scama</option>
                <option value='NS_SM2A'>NS SM2A</option>
                <option value='NS_SMVN'>NS SMVN</option>
                <option value='NS_SOBERMA'>NS SOBERMA</option>
                <option value='NS_SOMMA'>NS SOMMA</option>
                <option value='NS_SUPPORT'>NS SUPPORT</option>
                <option value='SCAMA_BEAUSITE'>SCAMA BEAUSITE</option>
                <option value='Scama_MI_Ismail'>Scama MI Ismail</option>
                <option value='Scama_Mly_Ismail'>Scama Mly Ismail</option>
                <option value='SCAMASIEGE'>SCAMA SIEGE</option>
                <option value='Settat'>Settat</option>
                <option value='Siège'>Siège</option>
                <option value='SMVN'>SMVN</option>
                <option value='SNGU'>SNGU</option>
                <option value='Somma_Settat'>Somma Settat</option>
            </optgroup>
              </select>";
  echo "</td >";
  echo "</tr>";

  echo "<tr>";
    echo "<th>";
  echo "Type";
  echo "</th >";
  echo "<td>";
  echo "   <select name='categorie'>
            <option value='".$d['categorie']."' hidden>".$d['categorie']." </option>
            <optgroup label='Root entity'>
                <option value='Antivirus'> Antivirus </option>
                <option value='Appe-Employee'> App e-Employee </option>
                <option value='APPCC'> APPCC </option>
                <option value='AppGCMA'> AppGCMA </option>
                <option value='Auto_Naps'> Auto Naps </option>
                <option value='C_Compliance'> C. Compliance </option>
                <option value='Citrix'> Citrix </option>
                <option value='Consumable'> Consumable </option>
                <option value='Sales_agreement'> Sales agreement </option>
                <option value='CRM'> CRM </option>
                <option value='Devopps'> Devopps </option>
                <option value='Loyalty'> Loyalty </option>
                <option value='GDoc'> GDoc </option>
                <option value='GENERAFI'> GENERAFI </option>
                <option value='GestorNet'> GestorNet </option>
                <option value='GSM'> GSM </option>
                <option value='Internet'> Internet  </option>
                <option value='Intranet'>Intranet </option>
                <option value='Telephone_line'> Telephone line </option>
                <option value='VPN_line'> VPN line </option>
                <option value='LOCPRO'> LOCPRO </option>
                <option value='System_Software'> System Software </option>
                <option value='Material'> Material </option>
                <option value='Messaging'> Messaging </option>
                <option value='Microsoft_Teams'> Microsoft Teams </option>
                <option value='Add'> Add </option>
                <option value='Moovapps'> Moovapps</option>
                <option value='Optimmo'> Optimmo </option>
                <option value='After-sales_service_tools'> After-sales service tools </option>
                <option value='PayRoll'> PayRoll </option>
                <option value='IP_Phone_extension'> IP Phone extension </option>
                <option value='Internal_telephone_extension'> Internal telephone extension </option>
                <option value='Data'> Data </option>
                <option value='Qalitel_Compare'> Qalitel Compare </option>
                <option value='Qalitel_Doc'> Qalitel Doc </option>
                <option value='WEB_MEETING'> WEB MEETING </option>
                <option value='Reporting'> Reporting </option>
                <option value='Add'> Add </option>
                <option value='Network'> Network </option>
                <option value='RIAPP'> RIAPP </option>
                <option value='Wise'> Wise </option>
                <option value='Website'> Sage Payroll & HR </option>
                <option value='SLV'> SLV </option>
                <option value='SMS'> SMS </option>
                <option value='Add'> Add </option>
                <option value='SRM'> SRM </option>
                <option value='VOXCO'> VOXCO </option>
                <option value='VPN_FortiClient'> VPN_FortiClient </option>
                <option value='WebEX'> WebEX </option>
                <option value='Wincar'>Wincar  </option>
                <option value='Windows'> Windows </option>
            </optgroup>
              </select>";
  echo "</td >";
  echo "</tr>";

  echo "<tr>";
    echo "<th>";
  echo "Catégorie";
  echo "</th >";
  echo "<td>";
  echo "<select name='type'>
            <option value='".$d['type']."' hidden>".$d['type']." </option>
            <option value='incident'>Incident</option>
            <option value='demande'>REQUEST</option>
           </select>";
  echo "</td >";
  echo "</tr>";

  echo "<tr>";
    echo "<th>";
  echo "Date d'ouverture";
  echo "</th >";
  echo "<td>";
  echo "<input type='date' name='date_ouverture' value='".$d['date_ouverture']."'>";
  echo "</td >";
  echo "</tr>";

echo "<tr>";
    echo "<th>";
  echo "Temps de résolution";
  echo "</th >";
  echo "<td>";
  echo "<input type='date' name='temps_resolution' value='".$d['temps_resolution']."'>";
  echo "</td >";
  echo "</tr>";
  echo "<tr>";
    echo "<th>";
  echo "Image";
  echo "</th >";
  echo "<td>";
  echo "
<label class='custom-file-upload'>
            Choisir une image
            <input type='file' id='fileUpload' name='fileUpload' accept='image/*'>
        </label>
        <span id='fileName'>Aucune image choisi</span>";
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
