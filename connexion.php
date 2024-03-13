<?php
session_start();
$bdd = new PDO('mysql:host=127.0.0.1;dbname=app_covoiturage', 'root', '');

if(isset($_POST['formconnexion'])) {
   $mailconnect = htmlspecialchars($_POST['mailconnect']);
   $mdpconnect = sha1($_POST['mdpconnect']);
   if(!empty($mailconnect) AND !empty($mdpconnect)) {
      $requser = $bdd->prepare("SELECT * FROM conducteur WHERE mail = ? AND motdepasse = ?");
      $requser->execute(array($mailconnect, $mdpconnect));
      $userexist = $requser->rowCount();
      if($userexist == 1) {
         $userinfo = $requser->fetch();
         $_SESSION['id_conducteur'] = $userinfo['id_conducteur'];
         $_SESSION['pseudo'] = $userinfo['pseudo'];
         $_SESSION['mail'] = $userinfo['mail'];

         header("Location: Untitled-1.php?id=".$_SESSION['id_conducteur']);
      } else {
         $erreur = "Mauvais mail ou mot de passe !";
      }
   } else {
      $erreur = "Tous les champs doivent être complétés !";
   }
}
?>
<?php
$bdd = new PDO('mysql:host=127.0.0.1;dbname=app_covoiturage', 'root', '');

if(isset($_POST['formconnexion'])) {
   $mailconnect = htmlspecialchars($_POST['mailconnect']);
   $mdpconnect = sha1($_POST['mdpconnect']);
   if(!empty($mailconnect) AND !empty($mdpconnect)) {
      $requser = $bdd->prepare("SELECT * FROM passager WHERE mail = ? AND motdepasse = ?");
      $requser->execute(array($mailconnect, $mdpconnect));
      $userexist = $requser->rowCount();
      if($userexist == 1) {
         $userinfo = $requser->fetch();
         $_SESSION['id'] = $userinfo['id'];
         $_SESSION['pseudo'] = $userinfo['pseudo'];
         $_SESSION['mail'] = $userinfo['mail'];
         header("Location: profil_passager.php?id=".$_SESSION['id']);
      } else {
         $erreur = "Mauvais mail ou mot de passe !";
      }
   } else {
      $erreur = "Tous les champs doivent être complétés !";
   }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>connexion</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.0/css/all.css" integrity="sha384-Mmxa0mLqhmOeaE8vgOSbKacftZcsNYDjQzuCOm6D02luYSzBG8vpaOykv9lFQ51Y" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <a href="https://icons8.com/icon/9345/covoiturage"></a>
   
</head>
<body>
    
    <section>
            <div class="inscrit">
        <img src="img/log.png" >
             </div>

    <div class="connexion" action="/action_page.php">
    

    <div class="forme">
            <h3>Rejoigner co-voiturage aujourd'hui</h3>
            <?php
    if(isset($erreur)) {
      echo '<font color="red">', '<font size="2px">'.$erreur."</font>";
   }
    ?>
            <form method="POST" action="">
        <div class="icon">
            <input type="email" name="mailconnect" placeholder="Mail" ><i class="fas fa-envelope"></i>
        </div>
        <div class="icon">
        <input type="password" name="mdpconnect" placeholder="Mot de passe" ><i class="fas fa-unlock-alt"></i>
    </div>
    <div>
        <input type="submit" name="formconnexion" value="Se connecter !" ></div>
    </form>
 
    <ul class="guide">
       <li> <a href="#"><span>Mot de passe</span> oublié?</a><br></li>
       <li>  <a href="inscription.php" class="membre">Nouveau membre?<span>inscrivez vous &#10132;</span></a></li>
    </ul>
    
    </div>
    
    </div>
   
</section>
</body>
</html>