<?php 
// Création du panier si n'existe pas dans la session de l'utilisateur
session_start();
$bdd = new PDO('mysql:host=127.0.0.1;dbname=app_covoiturage', 'root', '');
require('header_ps.php'); 

if (! isset($_SESSION['panier']))  $_SESSION['panier'] = array();

// Voici les données externes utilisées par le panier
$idt   = isset($_GET['idt'])   ? $_GET['idt']   : null;
$Pdepart   = isset($_GET['Pdepart'])   ? $_GET['Pdepart']   : null;
$Parrivee   = isset($_GET['Parrivee'])   ? $_GET['Parrivee']   : null;


$prix_t = isset($_GET['prix_t']) ? $_GET['prix_t'] : '?';
$place_disponible  = isset($_GET['place_disponible'])  ? $_GET['place_disponible']  : 1;

// Voici les traitements du panier
if ($idt == null) echo 'Veuillez sélectionner un article pour le mettre dans le panier!'; // Message si pas d'acticle sélectionné
else
if (isset($_GET['ajouter'])){ // Ajouter un nouvel article
  $_SESSION['panier'][$idt]['Pdepart']  = $Pdepart;
  $_SESSION['panier'][$idt]['Parrivee']  = $Parrivee;

  $_SESSION['panier'][$idt]['prix_t'] = $prix_t;
  $_SESSION['panier'][$idt]['place_disponible']  = $place_disponible;
} 
else if (isset($_GET['modifier']))  $_SESSION['panier'][$idt]['place_disponible'] = $place_disponible; // Modifier la quantité achetée
else if (isset($_GET['supprimer']))  unset($_SESSION['panier'][$idt]); // Supprimer un article du panier
else if (isset($_GET['valider'])){
  $reserver = $bdd->prepare("INSERT INTO reservation(Pdepart, Parrivee, places_r, prix_r, id_trajet, id_passager) VALUES(?, ?, ?, ?, ?, ?)");
  $reserver->execute(array($Pdepart, $Parrivee, $place_disponible, $prix_t, $idt, $_SESSION['id'] ));
  $succées = "Votre réservation a effectuée avec succées !";

  $reserver = $bdd->prepare("UPDATE trajet SET place_disponible = place_disponible - $place_disponible WHERE id_trajet = $idt");
  $reserver->execute(array($idt));

}
// Voici l'affichage du panier
echo '<div class="panier"><h2>Contenu de votre panier</h2>';
echo '<table><tr>';

if (isset($_SESSION['panier']) && count($_SESSION['panier'])>0){
  $total_panier = 0;
  foreach($_SESSION['panier'] as $idt=>$article_acheté){
    // On affiche chaque ligne du panier : nom, prix et quantité modifiable + 2 boutons : modifier la qté et supprimer l'article
    if (isset($article_acheté['Pdepart']) && isset($article_acheté['Parrivee']) 
     && isset($article_acheté['prix_t']) 
    && isset($article_acheté['place_disponible'])){
      echo '<form><td>'
      , $article_acheté['Pdepart'], 
      '</td><td>', $article_acheté['Parrivee'], 
      '</td><td>', number_format($article_acheté['prix_t'], 1, ',', ' '), ' DT</td>',
       '
       <td><input type="hidden" name="idt" value="', $idt , '" /></td>
       <td><input type="hidden" name="Pdepart" value="', $Pdepart , '" /></td>

       <td><input type="hidden" name="Parrivee" value="', $Parrivee , '" /></td>

       <td><input type="hidden" name="prix_t" value="', $prix_t , '" /></td>

       <td><input type="hidden" name="place_disponible" value="', $place_disponible , '" /></td>

        <td>Place: <input type="number" name="place_disponible"min=1 
        max="', $article_acheté['place_disponible'] , '" value="', $article_acheté['place_disponible'] , '" /></td>
        <td><input type="submit" name="modifier" class="modifier" value="Nouvelle Qté" /></td>
        <td><input type="submit" name="supprimer" class="supprimer"  value="Supprimer" /></td>
        <td><input type="submit" name="valider" value="valider" /></td>

      </form>
      </tr>
      </table>';
      
      // Calcule le prix total du panier 
      $total_panier += $article_acheté['prix_t'] * $article_acheté['place_disponible'];
    }
  }
  echo '<hr><h3>Total: ', number_format($total_panier, 2, ',', ' '), ' DT'; // Affiche le total du panier
}
else { echo 'Votre panier est vide'; } // Message si le panier est vide
echo "";
?>
<html>
  <head>
    <style>
      .panier{
        margin-top:3em;
        background:#fff;
        padding:3em;
      }
      .panier h2{
        text-align:center;
        margin-bottom:2em;
      }
      table{
        width:100%;
        font-weight:bold;
        padding:2em;
      }
      td{
        
      }
      input[type=submit]{
        border:none;
        background:inherit;
        cursor:pointer;
      }
      .modifier{
        color:green;
      }
      .supprimer{
        color:red;
      }
    </style>
  </head>
  <body>
    <?php if(isset($succées)) {
            echo '<font color="green">', '<font size="2px">'.$succées."</font>";         }
         
         ?>
         <body>
</html>