<?php
session_start();

$bdd = new PDO('mysql:host=127.0.0.1;dbname=app_covoiturage', 'root', '');

if(isset($_SESSION['id'])) {
   $requser = $bdd->prepare("SELECT * FROM passager WHERE id = ?");
   $requser->execute(array($_SESSION['id']));
   $user = $requser->fetch();
   if(isset($_POST['newpseudo']) AND !empty($_POST['newpseudo']) AND $_POST['newpseudo'] != $user['pseudo']) {
      $newpseudo = htmlspecialchars($_POST['newpseudo']);
      $insertpseudo = $bdd->prepare("UPDATE passager SET pseudo = ? WHERE id = ?");
      $insertpseudo->execute(array($newpseudo, $_SESSION['id']));
      header('Location: profil_passager.php?id='.$_SESSION['id']);
   }
   if(isset($_POST['newmail']) AND !empty($_POST['newmail']) AND $_POST['newmail'] != $user['mail']) {
      $newmail = htmlspecialchars($_POST['newmail']);
      $insertmail = $bdd->prepare("UPDATE passager SET mail = ? WHERE id = ?");
      $insertmail->execute(array($newmail, $_SESSION['id']));
      header('Location: profil_passager.php?id='.$_SESSION['id']);
   }
   if(isset($_POST['newmdp1']) AND !empty($_POST['newmdp1']) AND isset($_POST['newmdp2']) AND !empty($_POST['newmdp2'])) {
      $mdp1 = sha1($_POST['newmdp1']);
      $mdp2 = sha1($_POST['newmdp2']);
      if($mdp1 == $mdp2) {
         $insertmdp = $bdd->prepare("UPDATE passager SET motdepasse = ? WHERE id = ?");
         $insertmdp->execute(array($mdp1, $_SESSION['id']));
         header('Location: profil_passager.php?id='.$_SESSION['id']);
      } else {
         $msg = "Vos deux mdp ne correspondent pas !";
      }
   }

   if(isset($_POST['date_naissance']) AND !empty($_POST['date_naissance'])) {
      $date_naissance = htmlspecialchars($_POST['date_naissance']);
         $insertdate_naissance = $bdd->prepare("UPDATE passager SET date_naissance = ? WHERE id = ?");
         $insertdate_naissance->execute(array($date_naissance, $_SESSION['id']));

      }
      
      if(isset($_POST['gender']) AND !empty($_POST['gender'])) {
         $gender = htmlspecialchars($_POST['gender']);
            $insertgender = $bdd->prepare("UPDATE passager SET gender = ? WHERE id = ?");
            $insertgender->execute(array($gender, $_SESSION['id']));

            
         }

   if(isset($_FILES['avatar']) AND !empty($_FILES['avatar']['name'])) {
      $tailleMax = 2097152;
      $extensionsValides = array('jpg', 'jpeg', 'gif', 'png');
      if($_FILES['avatar']['size'] <= $tailleMax) {
         $extensionUpload = strtolower(substr(strrchr($_FILES['avatar']['name'], '.'), 1));
         if(in_array($extensionUpload, $extensionsValides)) {
            $chemin = "passagers/avatars/".$_SESSION['id'].".".$extensionUpload;
            $resultat = move_uploaded_file($_FILES['avatar']['tmp_name'], $chemin);
            if($resultat) {
               $updateavatar = $bdd->prepare('UPDATE passager SET avatar = :avatar WHERE id = :id');
               $updateavatar->execute(array(
                  'avatar' => $_SESSION['id'].".".$extensionUpload,
                  'id' => $_SESSION['id']
                  ));
               header('Location: profil_passager.php?id='.$_SESSION['id']);
            } else {
               $msg = "Erreur durant l'importation de votre photo de profil";
            }
         } else {
            $msg = "Votre photo de profil doit être au format jpg, jpeg, gif ou png";
         }
      } else {
         $msg = "Votre photo de profil ne doit pas dépasser 2Mo";
      }
   }
    

?>
<html>
   <head>
      <title>TUTO PHP</title>
      <meta charset="utf-8">
      <style>
.section{
   margin-top: 3em;
   background-color: #fff;
    padding: 2em;
}
.section h2{
   text-align:center;
   margin-bottom: 2em;

}
table{
width: 60%;
    margin: 15px auto;
    font-weight:bolder;
    }
    td{
       padding:0.5em;
    }
input{
   width: 80%;
    padding: 0.8em;
    font-weight:bolder;

}
select{
   width: 80%;
    padding: 0.8em;
    font-weight:bolder;
}
.msg{
   color:red;
}
.submit{
   border:none;
   color:#fff;
   background-color: #1da1f2;

}

</style>
   </head>
   <body>
       <?php require('header_ps.php') ;?>
       <div class="section">
         <h2>Edition de mon profil</h2>
             <table>
                 <tr>
            <form method="POST" action="" enctype="multipart/form-data">

           <td>    <label>Pseudo :</label></td>
           <td> <input type="text" name="newpseudo" placeholder="Pseudo" value="<?php echo $user['pseudo']; ?>" /></td>
</tr>
           <tr>
           <td> <label>Mail :</label></td>
           <td>  <input type="text" name="newmail" placeholder="Mail" value="<?php echo $user['mail']; ?>" /></td>
</tr>
<tr>
           <td>   <label>Mot de passe :</label></td>
           <td> <input type="password" name="newmdp1" placeholder="Mot de passe"/></td>
</tr>
           <td> <label>Confirmation - mot de passe :</label></td>
           <td><input type="password" name="newmdp2" placeholder="Confirmation du mot de passe" /></td>

<tr>
           <td>  <label>Date de naissance:</label></td>
           <td>  <input type = "date" name="date_naissance" placeholder="Date" value="<?php echo $user['date_naissance']; ?>" ></td>

</tr>

<tr>
<td><label>sexe :</label></td>
<td> <select name="gender"> 
                   <option>Male </option>
                   <option>Femme </option>
               </select>  </td>
</tr>
<tr>
<td><label>Avatar :</label></td>
<td><input type="file" name="avatar" /></td>
</tr>
              <tr> 
              <td><span class="msg"><?php if(isset($msg)) { echo $msg; } ?></span></td>
              <td> <input type="submit" class="submit" name="form" value="Mettre à jour mon profil !" /></td>
</tr>
               

            </form>
            
</table>

      </div>
   </body>
</html>
<?php   
}
else {
   header("Location: connexion.php");
}
?>