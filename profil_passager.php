<?php
session_start();

$bdd = new PDO('mysql:host=127.0.0.1;dbname=app_covoiturage', 'root', '');

if(isset($_GET['id']) AND $_GET['id'] > 0) {
    $getid = intval($_GET['id']);
    $requser = $bdd->prepare('SELECT * FROM passager WHERE id = ?');
    $requser->execute(array($getid));
    $userinfo = $requser->fetch();

    
    $msg = $bdd->prepare('SELECT * FROM messages WHERE id_passager = ? ORDER BY date_msg DESC limit 5');
    $msg->execute(array($getid));
    $msg_nbr = $msg->rowCount();
?>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>CO-VOITURAGE en tunisie</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" type="text/css" media="screen" href="style_pr.css">

    <link rel="stylesheet" type="text/css" media="screen" href="msg.css">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.0/css/all.css" integrity="sha384-Mmxa0mLqhmOeaE8vgOSbKacftZcsNYDjQzuCOm6D02luYSzBG8vpaOykv9lFQ51Y" crossorigin="anonymous">
    <link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel = "stylesheet">
 <script src = "https://code.jquery.com/jquery-1.10.2.js"></script>
 <script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

</head>
<body>
  

    <!--Navigation-->
    <nav class="navbar">
        <div class="logo"><a href="#">CO-VOITURAGE |<span>en tunisie</span> </a></div>

        <ul>

         <li><a href="rechercher.php?id=<?= $_SESSION['id'] ?>"><i class="fas fa-search"></i> Rechercher un trajet</a></li>

            <div class="dropdown">
            <div class="avatar">
            <?php
         if(!empty($userinfo['avatar']))
         {
         ?>
       
          <img src="passagers/avatars/<?php echo $userinfo['avatar']; ?>" />

         <?php
      }
         ?>
    <span > Bienvenue</span> <span class="hello"> <?php echo $userinfo['pseudo']; ?> <i class="fas fa-angle-down"> </i></span> 
  </div>
    <div class="dropdown-content">
    <?php
         if(isset($_SESSION['id']) AND $userinfo['id'] == $_SESSION['id']) {
            ?>
      <a href="deconnexion.php">Se déconnecter</a>
    </div>
  </div> 
        </ul>
        <?php
            }
         ?>
    </nav>
    

<section>
<div class="tab">
  <button class="tablinks" onclick="openCity(event, 'compte')"   id="defaultOpen">Mon compte </button>
  <button class="tablinks" onclick="openCity(event, 'Mes covoiturages')" >Mes covoiturages</button>
  <button class="tablinks" onclick="openCity(event, 'Mes paiements')">Mes paiements</button>

  <button class="tablinks" onclick="openCity(event, 'Tableau du bord')">Tableau du bord</button>
</div>

<div id="compte" class="tabcontent">

   <div class="compte">
        <h1> Mon compte </h1>
         <h4> Mon compte et préférences
         <span class="hr"></span>
         </h4>
         <div class="infoprofil">
         <div class="image">
          <img src="passagers/avatars/<?php echo $userinfo['avatar']; ?>" />

         </div>
       <div class="infor">
       <div class="pseudo">
       <span class="pseudo"> <?php echo $userinfo['pseudo']; ?></span>
       </div>
         <div class="gender">
         <span class="gender"> <?php echo $userinfo['gender']; ?></span>
         </div>
         <div class="mail">
        E-mail: <span class="mail"> <?php echo $userinfo['mail']; ?></span>

         </div>
         <div class="tel">
        Téléphone: <span class="tel"> <?php echo $userinfo['date_naissance']; ?></span>
         </div>
         </div>

      <div class="modif" >
      <a  class="edit_profil" href="edition_pr_passager.php?id=<?= $_SESSION['id'] ?>">Modifier mon profil</a>
      </div>

       </div>


</div>  




</div>

<div id="Mes covoiturages" class="tabcontent">
<h3>Mes covoiturage</h3>
  <p>Tokyo is the capital of Japan.</p>
</div>

<div id="Tableau du bord" class="tabcontent">
<div class="boite">

   <?php
   if($msg_nbr == 0) { echo "Vous n'avez aucun message..."; }
   while($m = $msg->fetch()) {

      $p_exp = $bdd->prepare('SELECT * FROM conducteur WHERE id_conducteur = ?');
      $p_exp->execute(array($m['id_conducteur']));
      $p_exp = $p_exp->fetch();

      $p_exp = $p_exp['pseudo'];

   ?>  

<table>

<tbody>
<tr>
<td class="pseudo">
 <b><?= $p_exp ?></b>
 </td>

 
 <td class="objet">
<a href="lecture_msg_passager.php?id=<?= $_SESSION['id'] ?>&idm=<?= $m['id_message'] ?>"<?php if($m['lu'] == 1) { ?><span style="color:grey"><?php } ?>

      <b>Objet:</b> <?= $m['objet'] ?>

      <?php if($m['lu'] == 1) { ?></span><?php } ?></a><br />

      </td>
      <td class="date">
      <?= $m['date_msg'] ?>
      </td>
      </td>
<td class="icon">
  <span><i class="far fa-envelope"></i></span></td>
   <?php } ?> 
   </tr>

   </tbody>
   </table>
</div>
</div>
<div id="Mes paiements" class="tabcontent">
  <h3>Mes paiements</h3>
  <p>Tokyo is the capital of Japan.</p>
</div>
</section>



    <script>
function openCity(evt, cityName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";
}

// Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpen").click();
</script>
<script>
var acc = document.getElementsByClassName("accordion");
var i;

for (i = 0; i < acc.length; i++) {
  acc[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var panel = this.nextElementSibling;
    if (panel.style.maxHeight){
      panel.style.maxHeight = null;
    } else {
      panel.style.maxHeight = panel.scrollHeight + "px";
    } 
  });
}
</script>

</body>
</html>
<?php   
}
else {
   header("Location: connexion.php");
}
?>