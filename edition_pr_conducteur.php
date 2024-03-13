<?php
session_start();

$bdd = new PDO('mysql:host=127.0.0.1;dbname=app_covoiturage', 'root', '');

if(isset($_SESSION['id_conducteur'])) {
   $requser = $bdd->prepare("SELECT * FROM conducteur WHERE id_conducteur = ?");
   $requser->execute(array($_SESSION['id_conducteur']));
   $user = $requser->fetch();
   if(isset($_POST['newpseudo']) AND !empty($_POST['newpseudo']) AND $_POST['newpseudo'] != $user['pseudo']) {
      $newpseudo = htmlspecialchars($_POST['newpseudo']);
      $insertpseudo = $bdd->prepare("UPDATE conducteur SET pseudo = ? WHERE id_conducteur = ?");
      $insertpseudo->execute(array($newpseudo, $_SESSION['id_conducteur']));
      header('Location:  Untitled-1.php?id='.$_SESSION['id_conducteur']);
   }
   if(isset($_POST['newmail']) AND !empty($_POST['newmail']) AND $_POST['newmail'] != $user['mail']) {
      $newmail = htmlspecialchars($_POST['newmail']);
      $insertmail = $bdd->prepare("UPDATE conducteur SET mail = ? WHERE id_conducteur = ?");
      $insertmail->execute(array($newmail, $_SESSION['id_conducteur']));
      header('Location:  Untitled-1.php?id='.$_SESSION['id_conducteur']);
   }
   if(isset($_POST['newmdp1']) AND !empty($_POST['newmdp1']) AND isset($_POST['newmdp2']) AND !empty($_POST['newmdp2'])) {
      $mdp1 = sha1($_POST['newmdp1']);
      $mdp2 = sha1($_POST['newmdp2']);
      if($mdp1 == $mdp2) {
         $insertmdp = $bdd->prepare("UPDATE conducteur SET motdepasse = ? WHERE id_conducteur = ?");
         $insertmdp->execute(array($mdp1, $_SESSION['id_conducteur']));
         header('Location:  Untitled-1.php?id='.$_SESSION['id_conducteur']);
      } else {
         $msg = "Vos deux mdp ne correspondent pas !";
      }
   }

   
   if(isset($_POST['tel']) AND !empty($_POST['tel'])) {
      $tel = htmlspecialchars($_POST['tel']);
      $tellength = strlen($tel);
      if($tellength == 8) {

         $inserttel = $bdd->prepare("UPDATE conducteur SET tel = ? WHERE id_conducteur = ?");
         $inserttel->execute(array($tel, $_SESSION['id_conducteur']));  

      }
      
         else {
            $msg = "verifier votre num";
         }
         
   }
   if(isset($_POST['permis']) AND !empty($_POST['permis'])) {
      $permis = htmlspecialchars($_POST['permis']);
      $tellength = strlen($permis);
      if($tellength == 8) {

         $inserttel = $bdd->prepare("UPDATE conducteur SET permis = ? WHERE id_conducteur = ?");
         $inserttel->execute(array($permis, $_SESSION['id_conducteur']));  

      }
      
         else {
            $msg = "verifier votre permis";
         }
         
   }
   if(isset($_POST['cin']) AND !empty($_POST['cin'])) {
      $cin = htmlspecialchars($_POST['cin']);
      $tellength = strlen($cin);
      if($tellength == 8) {

         $inserttel = $bdd->prepare("UPDATE conducteur SET cin = ? WHERE id_conducteur = ?");
         $inserttel->execute(array($cin, $_SESSION['id_conducteur']));  

      }
      
         else {
            $msg = "verifier votre cin";
         }
         
   }
   
   if(isset($_POST['date_naissance']) AND !empty($_POST['date_naissance'])) {
      $date_naissance = htmlspecialchars($_POST['date_naissance']);
         $insertdate_naissance = $bdd->prepare("UPDATE conducteur SET date_naissance = ? WHERE id_conducteur = ?");
         $insertdate_naissance->execute(array($date_naissance, $_SESSION['id_conducteur']));

      }
      
      if(isset($_POST['gender']) AND !empty($_POST['gender'])) {
         $gender = htmlspecialchars($_POST['gender']);
            $insertgender = $bdd->prepare("UPDATE conducteur SET gender = ? WHERE id_conducteur = ?");
            $insertgender->execute(array($gender, $_SESSION['id_conducteur']));

            
         }
    
   

if(isset($_FILES['avatar']) AND !empty($_FILES['avatar']['name'])) {
   $tailleMax = 2097152;
   $extensionsValides = array('jpg', 'jpeg', 'gif', 'png');
   if($_FILES['avatar']['size'] <= $tailleMax) {
      $extensionUpload = strtolower(substr(strrchr($_FILES['avatar']['name'], '.'), 1));
      if(in_array($extensionUpload, $extensionsValides)) {
         $chemin = "conducteurs/avatars/".$_SESSION['id_conducteur'].".".$extensionUpload;
         $resultat = move_uploaded_file($_FILES['avatar']['tmp_name'], $chemin);
         if($resultat) {
            $updateavatar = $bdd->prepare('UPDATE conducteur SET avatar = :avatar WHERE id_conducteur = :id_conducteur');
            $updateavatar->execute(array(
               'avatar' => $_SESSION['id_conducteur'].".".$extensionUpload,
               'id_conducteur' => $_SESSION['id_conducteur']
               ));
               header('Location:  Untitled-1.php?id='.$_SESSION['id_conducteur']);

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
      <link rel="stylesheet" type="text/css" media="screen" href="edition_pr.css">
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
   <?php  include('header.php');
?>

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
           <td>   <label>tel:</label></td>
           <td>  <input type="text" name="tel" id="tel" placeholder="Ex:06010" value="<?php echo $user['tel']; ?>"  /></p></td>
</tr>
<tr>
           <td>   <label>Permis:</label></td>
           <td>  <input type="text" name="permis" id="permis" placeholder="Ex:06010" value="<?php echo $user['permis']; ?>"  /></p></td>
</tr>
<tr>
           <td>   <label>CIN:</label></td>
           <td>  <input type="text" name="cin" id="cin" placeholder="Ex:06010" value="<?php echo $user['cin']; ?>"  /></p></td>
</tr>
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