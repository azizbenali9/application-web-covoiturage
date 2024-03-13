<?php
session_start();
require('header.php');

$bdd = new PDO('mysql:host=127.0.0.1;dbname=app_covoiturage', 'root', '');
if(isset($_SESSION['id_conducteur']) AND !empty($_SESSION['id_conducteur'])) {
   if(isset($_GET['idm']) AND !empty($_GET['idm'])) {
      $id_message = intval($_GET['idm']);
      $msg = $bdd->prepare('SELECT * FROM messages WHERE id_message = ? AND id_conducteur = ?');
      $msg->execute(array($_GET['idm'], $_SESSION['id_conducteur']));
      $msg_nbr = $msg->rowCount();
      $m = $msg->fetch();
      $p_exp = $bdd->prepare('SELECT pseudo FROM passager WHERE id = ?');
      $p_exp->execute(array($m['id_passager']));
      $p_exp = $p_exp->fetch();
      $p_exp = $p_exp['pseudo'];
?>
<!DOCTYPE html>
<html>
<head>
   <title>Lecture du message #<?= $id_message ?></title>
   <meta charset="utf-8" />
   <style>
.section{
   background-color: #fff;
   padding: 1em;
    width:35%;
    margin: 80px auto;
}
.reaction{
   text-align:center;
   padding-bottom: 1em;
}
   .dest{
padding-left:7em; 
padding-bottom: 1em;  }
.objet{
padding-bottom: 0.6em;  
}
   .contenu{
      border:1px solid #444;
      padding:0.5em;
      width:100%;
   }
</style>
</head>
<body>
<div class="section">
<div class="reaction">

    <a href="envoi_msg.php?idm=<?= $m['id_passager'] ?>&o=<?= urlencode($m['objet']) ?>&id=<?= $_SESSION['id_conducteur'] ?>">Répondre</a>  
  

      <a href="supp_msg.php?id=<?= $m['id_message'] ?>">Supprimer</a>
      </div>
      

     
      <div class="dest">

      <?php if($msg_nbr == 0) { echo "Erreur"; } else { ?>
      <b><?= $p_exp ?></b> vous a envoyé: 
      </div>


<div class="objet">
      <b>Objet:</b> <?= $m['objet'] ?>
      </div>



<div class="contenu">
      <?= nl2br($m['contenu']) ?>

</div>
      <?php } ?>
      </div>

</body>
</html>
<?php
      $lu = $bdd->prepare('UPDATE messages SET lu = 1 WHERE id_message = ?');
      $lu->execute(array($m['id_message']));
   }
} 
?>