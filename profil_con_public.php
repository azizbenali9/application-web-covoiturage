
<?php
session_start();
require_once('header_ps.php'); 

$bdd = new PDO("mysql:host=127.0.0.1;dbname=app_covoiturage;charset=utf8", "root", "");
if(isset($_SESSION['id']) AND !empty($_SESSION['id'])) {

if(isset($_GET['idc']) AND $_GET['idc'] > 0) {
    $get_id = htmlspecialchars($_GET['idc']);
   $con = $bdd->prepare('SELECT * FROM conducteur WHERE `id_conducteur` = ? ');
   $con->execute(array($get_id));
   if($con->rowCount() == 1) {
      $con = $con->fetch();
      $voiture = $bdd->prepare('SELECT * FROM voiture where id_conducteur = ? ');
      $voiture->execute(array($get_id));


      if(isset($_POST['envoi_message'])) {
        if(isset($_POST['contenu'],$_POST['objet']) AND !empty($_POST['contenu']) AND !empty($_POST['objet'])) {
          $contenu = htmlspecialchars($_POST['contenu']);
          $objet = htmlspecialchars($_POST['objet']);
      $ins = $bdd->prepare('INSERT INTO messages(id_conducteur, id_passager, contenu, objet, date_msg) VALUES (?,?,?,?,?)');
      $ins->execute(array( $get_id, $_SESSION['id'], $contenu, $objet, date("Y-m-d H:i:s")));
      $error = "Votre message a bien été envoyé !";

      }
     else {
        $error = "Veuillez compléter tous les champs";
     }
      }
      $pseudo = $con['pseudo'];
      $gender = $con['gender'];

      $date_naissance = $con['date_naissance'];

      $avatar = $con['avatar'];
    
   } else {
      die('Cet profil n\'existe pas !???');
   }
} else {
   die('erreur');

}


      
?>





<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Page Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="main.js"></script>
    <style>
    body{
    background: #eeeeee;
}
.cadre{
    width: 1170px;
    margin-right: auto;
    margin-left: auto;
    padding-left: 15px;
    padding-right: 15px;
    margin-top: 3cm;
}
.container{
    width: 100%;
    padding: 0;
    
}
.main{
    background-color: rgb(255, 255, 255);
    padding: 3em 4em;
}

.info_con{
   
    width: 65em;
}


.info_con .cont{
    display: flex;

}

.info_con img{
    border-radius: 50%;
width: 10em;
height: 10em;
}
.info_con .pseu{
    margin-left: 3em;
    margin-top: 30px;
}
.info_con .pseu .pseudo{
    font-weight: bold;
    font-size: 1.5rem;
    margin: 0px;}


    .info_con .pseu .gender{
        font-weight: bold;
        margin: 0px;
    color: #1da1f2;
margin-top:8px;
margin-bottom:8px;

}

        .info_con .pseu .date_naissance{
            font-weight: bold;
            margin: 0px;}
    
            .info_voi{
                background-color: rgb(233, 233, 233);
            padding: 2em;
            width: 20em;
            }
.info_voi .voiture{
    margin-bottom: 2em;
}
h4{
    font-weight: bold;
    font-size: 22px;
}

.info_voi .voiture .voi{
    margin-left: 1em;
}
.info_voi .voiture .voi .bold{
    font-weight: bold;
    margin-bottom: 0.1em;
}


 form{
    margin-left: 13em;
display: inline-block;
width: 30%;
}
form .objet{
    display: inline-block;

margin-bottom: 15px;
}
form .objet label{
    font-weight: bold;

margin-left: 4px;
}
form .objet input{

border: 2px solid;
}
 form .msg{
width: 100%;
}
 form .msg textarea{
    width: 100%;
    height: 10em;
    border: 2px solid;
}

 form .input{

border: none;
background: #1da1f2;
color: #fff;
padding: 6px 93px;
font-weight: bold;}

    
    </style>
</head>
<body>


<div class="cadre">
<div class="container">
<div class="main">

<div class="info_con">
<div class="cont">
<div class="img">
<img src="conducteurs/avatars/<?= $avatar ?>" />   

</div>
<div class="pseu">
<p class="pseudo"><?= $pseudo ?></p>
<p class="gender"><?= $gender ?></p>

<p class="date_naissance">Date naissance: <span><?= $date_naissance ?></span></p>

  </div>

  
</div>
<form method="POST">
<div class="objet">
<label>Objet:</label>

         <input type="text" name="objet" <?php if(isset($o)) { echo 'value="'.$o.'"'; } ?> />
</div>
<div class="msg">
         <textarea placeholder="Votre message" name="contenu"></textarea>
         <br /><br />
</div>
         <input type="submit" value="Envoyer" name="envoi_message" class="input" />
         <br /><br />
         <?php if(isset($error)) { echo '<span style="color:red">'.$error.'</span>'; } ?>
      </form>
      <br />
      <a href="profil_passager.php?id=<?= $_SESSION['id'] ?>">Boîte de réception</a>
</div>

<div class="info_voi">
<div class="cont">

  <?php while($a = $voiture->fetch()) { ?>
<div class="voiture">
    <h4>Voiture</h4>
    <div class="voi">
<div>Couleur : <span class="bold"><?= $a['couleur'] ?></span></div>
<div>Marque : <span class="bold"><?= $a['marque'] ?></span></div>
<div>Modele : <span class="bold"><?= $a['modele'] ?></span></div>
<div>Matricule : <span class="bold"><?= $a['matricule'] ?></span></div>
  </div>
  </div>
<?php } ?>
</div>

</div>
</div>

</div>
</div>
</body>
</html>
<?php
}
?>