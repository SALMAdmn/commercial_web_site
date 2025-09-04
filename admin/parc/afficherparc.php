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
a{
      color: grey;
    } 
.ajouter{
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
    margin-left:90px;
}
.ajouter:hover{
    border: 1px solid #001B60;
    background: #001B60;
    transition: 1s; 

}
/*telecharger style*/
.ouvrir{
  display: inline-block;
  color: grey;
  padding: 6px 17px;
  
}
/* Styles pour la fenêtre modale */
        .modal {
            display: none; /* Cachée par défaut */
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5); /* Fond semi-transparent */
        }
        .modal-content {
            background-color: #fff;
            margin: 20% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 400px;
            text-align: center;
        }
        .modal-buttons {
            margin-top: 20px;
        }
        /* Style pour les boutons personnalisés */
        .modal-buttons button {
            padding: 10px 20px;
            margin: 0 10px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            font-size: 16px;
        }
        .modal-buttons button.red {
            background-color: #ff6666; /* Rouge */
            color: #fff;
        }
        .modal-buttons button.green {
            background-color: #66cc66; /* Vert */
            color: #fff;
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
    display: inline-block;
    margin-left: 10%;
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
       <a href="afficherparc.php" class="sub-item" style="background-color: #001B60;">afficher</a>
       <a href="ajouterparc.php" class="sub-item">ajouter</a>
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



$sql="select * from parc";

$r=mysqli_query($con,$sql) or die('erreur exec recet');
    if(mysqli_num_rows($r)==0){
        echo "<h2 style='color:red; text-align:center; padding-top: 20%; font-size: 64px;'>LISTE VIDE</h2>";
    }
        else
        { 
?>
<section class="table">
<div class="tableau">
<table border="1" width="100%">
    <thead> 
        <tr>
                   <th>Type de produit</th> 
                   <th>Nom de produit</th>
                   <th>Utilisateur</th> 
                   <th>Lieu</th>
                   <th>Entreprise de vente</th>
                   <th>Poste de travail</th>
                   <th>Modéle identifié</th>
                   <th>Marque</th> 
                   <th>Livré par</th>
                   <th>description</th>
                   <th>derniére modification</th>
                   <th>Document connexe</th>
                   <th>Modifier</th>
                   <th>Supprimer</th>

        </tr>
    </thead>
    <tbody>        

<?php 
while($d = mysqli_fetch_array($r)){
    echo "<tr>";
    echo "<td>";
    echo $d['type'];
    echo "</td>";
    echo "<td>";
    echo $d['nom'];
    echo "</td >";
  echo "<td>";
  echo $d['utilisateur'];
  echo "</td >";
  echo "<td>";
  echo $d['lieu'];
  echo "</td >";
  echo "<td>";
    echo $d['entreprise'];
    echo "</td >";
    echo "<td>";
    echo $d['poste'];
    echo "</td >";
    echo "<td>";
    echo $d['modéle'];
    echo "</td >";
    echo "<td>";
    echo $d['marque'];
    echo "</td >";
    echo "<td>";
    echo $d['livreur'];
    echo "</td >";
    echo "<td>";
    echo $d['description'];
    echo "</td >";
    echo "<td>";
    echo $d['modification'];
    echo "</td >";
    echo "<td>";
    if (file_exists("fichier/".$d['nom'].".pdf")) {
echo '<a href="fichier/'.$d['nom'].'.pdf" class="ouvrir">'.$d['nom'].'.pdf</a>';
   }
 else {
    echo "aucun fichier";
  }
    echo "</td>";
  echo "<td><a href='modifierparc.php?id=".$d['nom']."'>modifier</a></td>";
   echo '<td><a href="#" onclick="showModal(\'supprimerparc.php?id='.$d['nom'].'\')">supprimer</a></td>';
    echo "</tr>";
}

    ?>

    </tbody>
</table>
<br>
<a href="ajouterparc.php" class="ajouter"><i class="fas fa-plus"></i>&nbsp Ajouter</a>
</div>

</section>

<?php } ?>
    


<!-- Fenêtre modale de confirmation -->
<div id="myModal" class="modal">
  <div class="modal-content">
    <p>Êtes-vous sûr de vouloir supprimer cet élément?</p>
    <div class="modal-buttons">
        <button class="red" onclick="confirmDelete()">Supprimer</button>
        <button class="green" onclick="hideModal()">Annuler</button>
    </div>
  </div>
</div>

<script>
// Fonction pour afficher la fenêtre modale
function showModal(confirmationUrl) {
    // Empêcher le comportement par défaut du lien (c'est-à-dire la navigation)
    event.preventDefault();
    // Afficher la fenêtre modale
    document.getElementById('myModal').style.display = 'block';
    // Stocker l'URL de confirmation dans un attribut de données du bouton de confirmation
    document.getElementById('confirmButton').dataset.confirmationUrl = confirmationUrl;
}

// Fonction pour cacher la fenêtre modale
function hideModal() {
    document.getElementById('myModal').style.display = 'none';
}

// Fonction pour confirmer la suppression et rediriger vers l'URL de confirmation
function confirmDelete() {
    // Récupérer l'URL de confirmation à partir de l'attribut de données du bouton de confirmation
    var confirmationUrl = document.getElementById('confirmButton').dataset.confirmationUrl;
    // Rediriger vers l'URL de confirmation
    window.location.href = confirmationUrl;
}
</script>

<!-- Champ caché pour stocker l'URL de confirmation -->
<input type="hidden" id="confirmButton">

<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/2.0.0/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.0.0/js/dataTables.bootstrap5.js"></script>



<script>
  new DataTable('#example');
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
       $('.tableau').css("margin-left", "10%");
       $('.menu-btn').css("visibility", "hidden");
     });
     //Active cancel button
     $('.close-btn').click(function(){
       $('.side-bar').addClass('active');
         $('.tableau').css("margin-left", "0%");
       $('.menu-btn').css("visibility", "visible");
     });
   });
</script>





</body>
</html>

