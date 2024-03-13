<?php
session_start();

$bdd = new PDO("mysql:host=127.0.0.1;dbname=app_covoiturage;charset=utf8", "root", "");
$mode_edition = 0;
if(isset($_GET['edit']) AND !empty($_GET['edit'])) {
   $mode_edition = 1;
   $edit_id = htmlspecialchars($_GET['edit']);
   $edit_voiture = $bdd->prepare('SELECT * FROM voiture WHERE id_voiture = ? AND id_conducteur = ? ');
   $edit_voiture->execute(array($edit_id, $_SESSION['id_conducteur']));
   if($edit_voiture->rowCount() == 1) {
      $edit_voiture = $edit_voiture->fetch();
   } else {
      die('Erreur : le\'voiture n\'existe pas...??????');
   }
}

if(isset($_POST['couleur'], $_POST['marque'], $_POST['modele'], $_POST['matricule'])) {
   if(!empty($_POST['couleur']) AND !empty ($_POST['marque']) AND !empty ($_POST['modele']) AND !empty ($_POST['matricule'])) {
      
      $couleur = htmlspecialchars($_POST['couleur']);
      $marque = htmlspecialchars($_POST['marque']);
      $modele = htmlspecialchars($_POST['modele']);
      $matricule = htmlspecialchars($_POST['matricule']);

     
      if($mode_edition == 0) {
         $a = $bdd->prepare('SELECT id_voiture FROM voiture WHERE id_conducteur = ?');
         $a->execute(array($_SESSION['id_conducteur']));

         if($a->rowCount() < 1) {
         
         $ins = $bdd->prepare('INSERT INTO voiture (couleur, marque, modele, matricule, id_conducteur) VALUES (?, ?, ?, ?, ?) ');
         $ins->execute(array($couleur, $marque, $modele, $matricule, $_SESSION['id_conducteur']));
         $message = 'Votre voiture a bien été posté';
         }
         else {

            $message = ' Vous avez deja une voiture';

         }
      }
      
      else {     

         $update = $bdd->prepare('UPDATE voiture SET couleur = ?, marque = ?, modele = ?, matricule = ? WHERE id_voiture = ? AND id_conducteur = ? ');
         $update->execute(array($couleur, $marque, $modele, $matricule,$edit_id, $_SESSION['id_conducteur']));
         $message = 'Votre voiture a bien été mis à jour !';

      }
      
   
   } else {
      $message = 'Veuillez remplir tous les champs';
   }
}

if(isset($_POST['Retour'])) {
    
   header('Location:  Untitled-1.php?id='.$_SESSION['id_conducteur']);

      
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
   <?php  include('header.php');
?>
            <div class="section">

         <h2>Edition de mon profil</h2>
         
            <form method="POST" action="" enctype="multipart/form-data">
            <table>
                 <tr>
                 <td>    <label>Couleur :</label></td>

    <td>  <input type="text" name="couleur" placeholder="couleur" <?php if($mode_edition == 1) { ?> value="<?= $edit_voiture['couleur'] ?>"<?php } ?> /></td>
               </tr>

               <tr>
                 <td>    <label>Marque :</label></td>
     <td> <input type="text" name="marque" placeholder="marque" <?php if($mode_edition == 1) { ?> value=" <?= $edit_voiture['marque'] ?>"<?php } ?> /></td>
      </tr>

      <tr>
                 <td>    <label>Modele :</label></td>
      <td> <input type="text" name="modele" placeholder="modele" <?php if($mode_edition == 1) { ?> value="<?= $edit_voiture['modele'] ?>"<?php } ?> /></td>
      </tr>

      <tr>
                 <td>    <label>Matricule :</label></td>
      <td> <input type="text" name="matricule" placeholder="matricule" <?php if($mode_edition == 1) { ?> value="<?= $edit_voiture['matricule'] ?>"<?php } ?> /></td>

      </tr>

      <tr>
      <td><span class="msg"><?php if(isset($message)) { echo $message; } ?></span></td>
               <td>  <input type="submit" class="submit"  value="Valider !" /></td>
               </tr>
   


            </form>
            </table>

      </div>
   </body>
</html>
