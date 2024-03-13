<?php
session_start();

$bdd = new PDO("mysql:host=127.0.0.1;dbname=app_covoiturage;charset=utf8", "root", "");
$mode_edition = 0;
if(isset($_GET['edit']) AND !empty($_GET['edit'])) {
   $mode_edition = 1;
   $edit_id = htmlspecialchars($_GET['edit']);
   $edit_trajet = $bdd->prepare('SELECT * FROM trajet WHERE id_trajet = ? AND id_conducteur = ? ');
   $edit_trajet->execute(array($edit_id, $_SESSION['id_conducteur']));
   if($edit_trajet->rowCount() == 1) {
      $edit_trajet = $edit_trajet->fetch();
   } else {
      die('Erreur : le\'trajet n\'existe pas...??????');
   }
}
if(isset($_POST['article_titre'], $_POST['article_contenu'])) {
   if(!empty($_POST['article_titre']) AND !empty($_POST['article_contenu'])) {
      
      $article_titre = htmlspecialchars($_POST['article_titre']);
      $article_contenu = htmlspecialchars($_POST['article_contenu']);
      if($mode_edition == 0) {
         $ins = $bdd->prepare('INSERT INTO trajet (titre, contenu, id_conducteur) VALUES (?, ?, ?)');
         $ins->execute(array($article_titre, $article_contenu, $_SESSION['id_conducteur']));
         $message = 'Votre trajet a bien été posté';
         header('Location:  Untitled-1.php?id='.$_SESSION['id_conducteur']);


      } else {
         $update = $bdd->prepare('UPDATE trajet SET titre = ?, contenu = ? WHERE id_trajet = ? AND id_conducteur = ? ');
         $update->execute(array($article_titre, $article_contenu, $edit_id, $_SESSION['id_conducteur']));
         $message = 'Votre trajet a bien été mis à jour !';

         header('Location: trajet.php?id='.$edit_id);
      }
   } else {
      $message = 'Veuillez remplir tous les champs';
   }
}

if(isset($_POST['annuler'])) {
    
   header('Location:  Untitled-1.php?id='.$_SESSION['id_conducteur']);

      
   } 

  
   


?>
<!DOCTYPE html>
<html>
<head>
   <title>Edition</title>
   <meta charset="utf-8">
</head>
<body>
   <form method="POST">
      <input type="text" name="article_titre" placeholder="Titre" <?php if($mode_edition == 1) { ?> value="<?= $edit_trajet['titre'] ?>"<?php } ?> /><br />
      <textarea name="article_contenu" placeholder="Contenu de l'article"><?php if($mode_edition == 1) { ?><?= 
      $edit_trajet['contenu'] ?><?php } ?></textarea><br />
      <input type="submit" value="Publier un trajet" />
      <input type="submit" name="annuler" value="Annuler !" />

   </form>
   <br />
   <?php if(isset($message)) { echo $message; } ?>
</body>
</html>
