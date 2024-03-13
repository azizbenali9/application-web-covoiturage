<?php
$bdd = new PDO('mysql:host=127.0.0.1;dbname=app_covoiturage', 'root', '');

if(isset($_POST['forminscriptionc'])) {
   $pseudo = htmlspecialchars($_POST['pseudo']);
   $mail = htmlspecialchars($_POST['mail']);
   $mail2 = htmlspecialchars($_POST['mail2']);
   $mdp = sha1($_POST['mdp']);
   $mdp2 = sha1($_POST['mdp2']);
   if(!empty($_POST['pseudo']) AND !empty($_POST['mail']) AND !empty($_POST['mail2']) AND !empty($_POST['mdp']) AND !empty($_POST['mdp2'])) {
      $pseudolength = strlen($pseudo);
      if($pseudolength <= 255) {
         if($mail == $mail2) {
            if(filter_var($mail, FILTER_VALIDATE_EMAIL)) {
               $reqmail = $bdd->prepare("SELECT * FROM conducteur WHERE mail = ?");
               $reqmail->execute(array($mail));
               $mailexist = $reqmail->rowCount();
               if($mailexist == 0) {
                  if($mdp == $mdp2) {
                     $insertmbr = $bdd->prepare("INSERT INTO conducteur(pseudo, mail, motdepasse, avatar) VALUES(?, ?, ?, ?)");
                     $insertmbr->execute(array($pseudo, $mail, $mdp, "default-user-icon.jpg"));
                     $succées = "Votre compte a bien été créé !";
                  } else {
                     $erreur = "Vos mots de passes ne correspondent pas !";
                  }
               } else {
                  $erreur = "Adresse mail déjà utilisée !";
               }
            } else {
               $erreur = "Votre adresse mail n'est pas valide !";
            }
         } else {
            $erreur = "Vos adresses mail ne correspondent pas !";
         }
      } else {
         $erreur = "Votre pseudo ne doit pas dépasser 255 caractères !";
      }
   } else {
      $erreur = "Tous les champs doivent être complétés !";
   }
}
?>
<?php
$bdd = new PDO('mysql:host=127.0.0.1;dbname=app_covoiturage', 'root', '');


if(isset($_POST['forminscriptionp'])) {
   $pseudo = htmlspecialchars($_POST['pseudo']);
   $mail = htmlspecialchars($_POST['mail']);
   $mail2 = htmlspecialchars($_POST['mail2']);
   $mdp = sha1($_POST['mdp']);
   $mdp2 = sha1($_POST['mdp2']);
   if(!empty($_POST['pseudo']) AND !empty($_POST['mail']) AND !empty($_POST['mail2']) AND !empty($_POST['mdp']) AND !empty($_POST['mdp2'])) {
      $pseudolength = strlen($pseudo);
      if($pseudolength <= 255) {
         if($mail == $mail2) {
            if(filter_var($mail, FILTER_VALIDATE_EMAIL)) {
               $reqmail = $bdd->prepare("SELECT * FROM passager WHERE mail = ?");
               $reqmail->execute(array($mail));
               $mailexist = $reqmail->rowCount();
               if($mailexist == 0) {
                  if($mdp == $mdp2) {
                     $insertmbr = $bdd->prepare("INSERT INTO passager(pseudo, mail, motdepasse, avatar) VALUES(?, ?, ?, ?)");
                     $insertmbr->execute(array($pseudo, $mail, $mdp, "membre.png"));
                     $succées = "Votre compte a bien été créé ! ";
                  } else {
                     $erreur = "Vos mots de passes ne correspondent pas !";
                  }
               } else {
                  $erreur = "Adresse mail déjà utilisée !";
               }
            } else {
               $erreur = "Votre adresse mail n'est pas valide !";
            }
         } else {
            $erreur = "Vos adresses mail ne correspondent pas !";
         }
      } else {
         $erreur = "Votre pseudo ne doit pas dépasser 255 caractères !";
      }
   } else {
      $erreur = "Tous les champs doivent être complétés !";
   }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>jQuery UI Tabs - Default functionality</title>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.0/css/all.css" integrity="sha384-Mmxa0mLqhmOeaE8vgOSbKacftZcsNYDjQzuCOm6D02luYSzBG8vpaOykv9lFQ51Y" crossorigin="anonymous">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <link rel="stylesheet" type="text/css" media="screen" href="style.css">

  <script>
  $( function() {
    $( "#tabs" ).tabs();
  } );
  </script>

  <style>
section .connexion #tabs .tabs{
list-style: none;
display: flex;
}
section .connexion #tabs .tabs li {
border:none;
margin-bottom:12px;
margin-left:12px;

}
section .connexion #tabs .tabs li a{
   text-decoration: none;
   font-size: 15px;
   font-weight: bolder;
   padding:8px 22px;
   border-radius: 25px;

}
section .connexion #tabs .tab1 a{
   color:#fff;
   background-color: #f7684f;

}
section .connexion #tabs .tab2 a{
   color:#fff;
   background-color: #4ff773;

}
  </style>
</head>
<body>
<section>
         <div class="inscrit">
        <img src="img/log.png" >
         </div>

 <div class="connexion">
 
 <div id="tabs">
 <h3>Rejoigner co-voiturage aujourd'hui</h3>

  <ul class="tabs">
    <li class="tab1"><a href="#tabs-1" >Conducteur</a></li>
    <li class="tab2"><a href="#tabs-2" >Passager</a></li>
  </ul>
  
  <div id="tabs-1">
  <?php
         if(isset($erreur)) {
            echo '<font color="red">', '<font size="2px">'.$erreur."</font>";
         }
         

         elseif(isset($succées)) {
            echo '<font color="green">', '<font size="2px">'.$succées."</font>";         }
         
         ?>

  <div class="forme">
  <form method="POST" action="">
        <div class="icon">
            <input type="text" placeholder="Votre pseudo" id="pseudo" name="pseudo" value="<?php if(isset($pseudo)) { echo $pseudo; } ?>"><i class="fas fa-user"></i>
        </div>
        <div class="icon">
            <input type="email" placeholder="Votre mail" id="mail" name="mail" value="<?php if(isset($mail)) { echo $mail; } ?>"><i class="fas fa-envelope"></i>
        </div>
        <div class="icon">
            <input type="email" placeholder="Confirmez votre mail" id="mail2" name="mail2" value="<?php if(isset($mail2)) { echo $mail2; } ?>" ><i class="fas fa-envelope"></i>
        </div>
        <div class="icon">
        <input type="password" placeholder="Votre mot de passe" id="mdp" name="mdp"><i class="fas fa-unlock-alt"></i>
    </div>
    <div class="icon">
        <input type="password" placeholder="Confirmez votre mdp" id="mdp2" name="mdp2"d><i class="fas fa-unlock-alt"></i>
    </div>
    <div>
        <input type="submit" name="forminscriptionc" value="inscrivez" >
    </div>
    <ul class="guide">
       <li>  <a href="connexion.php" class="membre">Vous avez déja un compte?<span>connectez &#10132;</span></a></li>
    </ul>
    </div>
</form>

   </div>
  <div id="tabs-2">
  <?php
         if(isset($erreur)) {
            echo '<font color="red">', '<font size="2px">'.$erreur."</font>";
         }
         

         elseif(isset($succées)) {
            echo '<font color="green">', '<font size="2px">'.$succées."</font>";         }
         
         ?>
  <div class="forme">
  <form method="POST" action="">
        <div class="icon">
            <input type="text" placeholder="Votre pseudo" id="pseudo" name="pseudo" value="<?php if(isset($pseudo)) { echo $pseudo; } ?>"><i class="fas fa-user"></i>
        </div>
        <div class="icon">
            <input type="email" placeholder="Votre mail" id="mail" name="mail" value="<?php if(isset($mail)) { echo $mail; } ?>"><i class="fas fa-envelope"></i>
        </div>
        <div class="icon">
            <input type="email" placeholder="Confirmez votre mail" id="mail2" name="mail2" value="<?php if(isset($mail2)) { echo $mail2; } ?>" ><i class="fas fa-envelope"></i>
        </div>
        <div class="icon">
        <input type="password" placeholder="Votre mot de passe" id="mdp" name="mdp"><i class="fas fa-unlock-alt"></i>
    </div>
    <div class="icon">
        <input type="password" placeholder="Confirmez votre mdp" id="mdp2" name="mdp2"d><i class="fas fa-unlock-alt"></i>
    </div>
    <div>
        <input type="submit" name="forminscriptionp" value="inscrivez" >
    </div>
    <ul class="guide">
       <li>  <a href="connexion.php" class="membre">Vous avez déja un compte?<span>connectez &#10132;</span></a></li>
    </ul>
    </div>
</form>

   </div>   </div>
</div>
      </section>

     
  
</div>
 
 
</body>
</html>