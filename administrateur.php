<?php
$bdd = new PDO('mysql:host=127.0.0.1;dbname=app_covoiturage', 'root', '');
if(isset($_GET['type']) AND $_GET['type'] == 'conducteur') {
   if(isset($_GET['confirme']) AND !empty($_GET['confirme'])) {
      $confirme = (int) $_GET['confirme'];
      $req = $bdd->prepare('UPDATE conducteur SET confirme = 1 WHERE id_conducteur = ?');
      $req->execute(array($confirme));
   }
   if(isset($_GET['supprime']) AND !empty($_GET['supprime'])) {
      $supprime = (int) $_GET['supprime'];
      $req = $bdd->prepare('DELETE FROM conducteur WHERE id_conducteur = ?');
      $req->execute(array($supprime));
   }
} elseif(isset($_GET['type']) AND $_GET['type'] == 'passager') {
   if(isset($_GET['confirme']) AND !empty($_GET['confirme'])) {
      $confirme = (int) $_GET['confirme'];
      $req = $bdd->prepare('UPDATE passager SET confirme = 1 WHERE id = ?');
      $req->execute(array($confirme));
   }
   if(isset($_GET['supprime']) AND !empty($_GET['supprime'])) {
      $supprime = (int) $_GET['supprime'];
      $req = $bdd->prepare('DELETE FROM passager WHERE id = ?');
      $req->execute(array($supprime));
   }
}
elseif(isset($_GET['type']) AND $_GET['type'] == 'trajet') {
    if(isset($_GET['confirme']) AND !empty($_GET['confirme'])) {
       $confirme = (int) $_GET['confirme'];
       $req = $bdd->prepare('UPDATE trajet SET confirme = 1 WHERE id = ?');
       $req->execute(array($confirme));
    }
    if(isset($_GET['supprime']) AND !empty($_GET['supprime'])) {
       $supprime = (int) $_GET['supprime'];
       $req = $bdd->prepare('DELETE FROM trajet WHERE id_trajet = ?');
       $req->execute(array($supprime));
    }
 }
$conducteur = $bdd->query('SELECT * FROM conducteur ORDER BY id_conducteur DESC');
$passager = $bdd->query('SELECT * FROM passager ORDER BY id DESC ');
$trajet = $bdd->query('SELECT * FROM trajet  ');

?>
<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8" />
   <title>Administration</title>
   <style>
       .main{
           width:80%;
           margin:15px auto;
       }
       .main h2{
           text-align:center;
       }
   table{
       width:100%;
   }
   .confirmer{
       color:green;
   }
   .supprimer{
       color:red;
   }
   </style>
</head>
<body>
   <div class="main">
       <h2>Liste de conducteurs</h2>
       <table><tr>
           <td>id</td>
           <td>pseudo</td>

           <td>E-mail</td>

           <td>téléphone</td>
           <td>date_naissance</td>
           <td>cin</td>
           <td>permis</td>

</tr>
           <tr>
      <?php while($m = $conducteur->fetch()) { ?>
     <td>
          <?= $m['id_conducteur'] ?>
         </td>
      
      
<td>
       <?= $m['pseudo'] ?>
       </td>
       <td>
       <?= $m['mail'] ?>
      </td>
      <td>

       <?= $m['tel'] ?>
      </td>
      <td>

       <?= $m['date_naissance'] ?>
      </td>
      <td>

<?= $m['cin'] ?>
</td>
<td>

<?= $m['permis'] ?>
</td>
      
      <?php if($m['confirme'] == 0) { ?> 
        <td>
        <a class="confirmer" href="administrateur.php?type=conducteur&confirme=<?= $m['id_conducteur'] ?>">Confirmer</a><?php } ?>
      </td>
      <td>
         <a class="supprimer" href="administrateur.php?type=conducteur&supprime=<?= $m['id_conducteur'] ?>">Supprimer</a>
      </td>
      </tr>

      <?php } ?>
      </table>
      </div>
   <br /><br />
   <div class="main">
   <h2>Liste de passagers</h2>
   <table><tr>
           <td>id</td>
           <td>pseudo</td>

           <td>E-mail</td>

           <td>date_naissance</td>
          

</tr>
           <tr>
      <?php while($c = $passager->fetch()) { ?>

      <td>
          <?= $c['id'] ?>
         </td>
      <td>

       <?= $c['pseudo'] ?>
      </td>
      <td>

       <?= $c['mail'] ?>
      </td>
      
      <td>

       <?= $c['date_naissance'] ?>
      </td>
      <td>



       <?php if($c['confirme'] == 0) { ?> 
        <td>
         <a class="confirmer" href="administrateur.php?type=passager&confirme=<?= $c['id'] ?>">Confirmer</a><?php } ?> 
       </td>
       <td>
      <a class="supprimer" href="administrateur.php?type=passager&supprime=<?= $c['id'] ?>">Supprimer</a>
       </td>
      <?php } ?>
      </tr>
      </table>
      </div>

      <br /><br />
   <div class="main">
   <h2>Liste de trajets</h2>
   <table><tr>
           <td>id_trajet</td>
           <td>Pdepart</td>

           <td>Parrivee</td>

           <td>id_conducteur</td>
           <td>date_t</td>
           <td>heure_t</td>
           <td>place_disponible</td>
           <td>prix_t</td>

</tr>
   
           <tr>
      <?php while($t = $trajet->fetch()) { ?>

      <td>
          <?= $t['id_trajet'] ?>
         </td>
      <td>

       <?= $t['Pdepart'] ?>
      </td>
      <td>

       <?= $t['Parrivee'] ?>
      </td>
      
      <td>

       <?= $t['id_conducteur'] ?>
      </td>
<td>
      <?= $t['date_t'] ?>
</td>
<td>

<?= $t['heure_t'] ?>
</td>
<td>

<?= $t['place_disponible'] ?>
</td>
<td>

<?= $t['prix_t'] ?>
</td>
       <?php if($t['confirme'] == 0) { ?> 
        <td>
         <a class="confirmer" href="administrateur.php?type=trajet&confirme=<?= $t['id_trajet'] ?>">Confirmer</a><?php } ?> 
       </td>
       <td>
      <a class="supprimer" href="administrateur.php?type=trajet&supprime=<?= $t['id_trajet'] ?>">Supprimer</a>
       </td>
      <?php } ?>
      </tr>
      </table>
      </div>

</body>
</html>