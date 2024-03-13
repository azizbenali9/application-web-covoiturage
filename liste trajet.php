<?php
session_start();

$bdd = new PDO("mysql:host=127.0.0.1;dbname=app_covoiturage;charset=utf8", "root", "");
require('header_ps.php'); 

if(isset($_GET['idt']) AND !empty($_GET['idt'])) {
   $get_id = htmlspecialchars($_GET['idt']);

   $trajet = $bdd->prepare('SELECT * FROM trajet WHERE id_trajet = ?');
   $trajet->execute(array($get_id));
   if($trajet->rowCount() == 1) {


      $trajet = $trajet->fetch();
      $Pdepart = $trajet['Pdepart'];
      $Parrivee = $trajet['Parrivee'];
      $date_t = $trajet['date_t'];
      $heure_t = $trajet['heure_t'];
      $place_disponible = $trajet['place_disponible'];
      $prix_t = $trajet['prix_t'];
      $music = $trajet['music'];
      $fumeur = $trajet['fumeur'];
      $bagage = $trajet['bagage'];

      $id_conducteur = $trajet['id_conducteur'];
    



   } else {
      die('Cet trajet n\'existe pas !???');
   }


 }else {
   die('erreur');

}
?>
<!DOCTYPE html>
<html>
<head>
   <title>Accueil</title>
   <meta charset="utf-8">
   <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.0/css/all.css" integrity="sha384-Mmxa0mLqhmOeaE8vgOSbKacftZcsNYDjQzuCOm6D02luYSzBG8vpaOykv9lFQ51Y" crossorigin="anonymous">

   <link rel="stylesheet" type="text/css" media="screen" href="style_pr.css">

</head>

<style>
body {font-family: Arial, Helvetica, sans-serif;}

/* Full-width input fields */



/* Extra styles for the cancel button */
.cancelbtn {
  width: auto;
  padding: 10px 18px;
  background-color: #f44336;
}

/* Center the image and position the close button */
.imgcontainer {
  text-align: center;
  margin: 24px 0 12px 0;
  position: relative;
}



.container {
  padding: 16px;
  text-align:left;
}
span.psw {
  float: right;
  padding-top: 16px;
}


/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
  padding-top: 60px;
  border-radius:6px;
}

/* Modal Content/Box */
.modal-content {
  background-color: #fefefe;
  margin: 5% auto 15% auto; /* 5% from the top, 15% from the bottom and centered */
  border: 1px solid #888;
  width: 80%; /* Could be more or less, depending on screen size */
  border-radius: 24px;
}
.tt{
  border: 1px solid #e2e2e2;
padding: 0.5em;
margin: 2em 0px;
}
/* The Close Button (x) */
.close {
  position: absolute;
  right: 25px;
  top: -22px;
  color: #000;
  font-size: 35px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: red;
  cursor: pointer;
}
.places_r{
  width: 100%;
display: inline-block;
}
.places_r span{
font-weight: bold;
color:#444;
margin-right: 10px;
display: inline-block;
}
.places_r select{
  border-color:rgb(204, 204, 204);
  border-radius: 4px;
  padding: 7px 20px;
  font-weight: bold;
}
.reglager{
  width: 100%;
text-align: right;
}
/* Add Zoom Animation */
.animate {
  -webkit-animation: animatezoom 0.6s;
  animation: animatezoom 0.6s
}

@-webkit-keyframes animatezoom {
  from {-webkit-transform: scale(0)} 
  to {-webkit-transform: scale(1)}
}
  
@keyframes animatezoom {
  from {transform: scale(0)} 
  to {transform: scale(1)}
}

/* Change styles for span and cancel button on extra small screens */
@media screen and (max-width: 300px) {
  span.psw {
     display: block;
     float: none;
  }
  .cancelbtn {
     width: 100%;
  }
}
</style>

<body class="pagetrajet">
<div class="main">

<div class="heure-date">
          <span class="heure"><?= $heure_t ?></span>
          <span class="date"><?= $date_t ?></span>

      </div>
      
      <div class="trajet">

        <div class="icon">
        <span class="caricons"><i class="fas fa-map-marker-alt"></i></span>
          <span class="caricons"><i class="fas fa-arrow-right"></i></span>
        </div>

        <div class="destination">
        <div class="depart"><strong><?= $Pdepart ?></strong></div>
        <div class="arrivee"><strong><?= $Parrivee ?></strong></div>
        </div>

      </div>

      <div class="conducteur">

      <a href="profil_con_public.php?idc=<?= $trajet['id_conducteur'] ?>&id=<?= $_SESSION['id'] ?>">

          <div><strong>
      Voir profil conducteur 
  
</strong>

          </div>

          </a>

        <div class="prix-places">
            <div class="places"><?= $place_disponible ?> places disponibles</div>
          <div class="prix"><?= $prix_t ?> DT<span> par place</span> </div>
    </div>
    </div>

<div class="Préferences">
  
  <h4>Préferences:</h4>
  <div class="pre">
  <p>Music:<span> <?= $music ?></span></p>
  <p>Fumeur:<span> <?= $fumeur ?></span></p>
  <p>Bagage:<span> <?= $bagage ?></span></p>
</div>

</div>

    </div>
    

    <div class="reglage">
   <span>
   <button class="ms"  onclick="document.getElementById('id01').style.display='block'" >Réserver cet trajet</button>

<div id="id01" class="modal">
  
  <form class="modal-content animate" action="panier.php">
    <div class="imgcontainer">
      <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
    </div>

    <div class="container">
      <div class="tt">
    <div class="heure-date">
          <span class="heure"><?= $heure_t ?></span>
          <span class="date"><?= $date_t ?></span>

      </div>
      <div class="trajet">

        <div class="icon">
        <span class="caricons"><i class="fas fa-map-marker-alt"></i></span>
          <span class="caricons"><i class="fas fa-arrow-right"></i></span>
        </div>

        <div class="destination">
        <div class="depart"><strong><?= $Pdepart ?></strong></div>
        <div class="arrivee"><strong><?= $Parrivee ?></strong></div>
        </div>

 

      </div>
      <div class="place-prix">
        <div class="place">
          <span><strong><?= $place_disponible ?> places</strong></span>

        </div>
        
        <div class="prix">
        <span><strong><?= $prix_t ?> DT</strong></span>
        </div>

      </div>
      
      </div>
<div class="places_r">
  <span>Nombre de places :</span>



  <select>
  <?php

for ($i = 1; $i <= $place_disponible; $i++) {?>
  <option>
    
  <?php echo  $i; ?>


  </option>
    <?php }?>

</select>
</div>
<div class="reglager" >
 <a class="ms" style="float=right"
         href="panier.php?id=<?= $_SESSION['id'] ?>&idt=<?= $trajet['id_trajet'] ?>&Pdepart=<?= $trajet['Pdepart'] ?>&Parrivee=<?= $trajet['Pdepart'] ?>&prix_t=<?= $trajet['prix_t'] ?>&place_disponible=<?= $trajet['place_disponible'] ?>&ajouter">ajouter au panier</a>
    </div>

    </div>

    
  </form>
</div>

</span>
</div>


<script>
// Get the modal
var modal = document.getElementById('id01');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>
</body>
</html>
