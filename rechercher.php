



<?php
session_start();

$bdd = new PDO('mysql:host=127.0.0.1;dbname=app_covoiturage', 'root', '');


$trajet = $bdd->query('SELECT * FROM trajet WHERE date_t > NOW() order by  date_t desc limit 3');

if(isset($_GET['depart'], $_GET['arrivee'], $_GET['date'])) {
    if(!empty($_GET['arrivee'])  AND !empty($_GET['depart']) ) {

   $depart = htmlspecialchars($_GET['depart']);
   $arrivee = htmlspecialchars($_GET['arrivee']);
   $date = htmlspecialchars($_GET['date']);

   $trajet = $bdd->query('SELECT * FROM trajet WHERE  Pdepart LIKE "%'.$depart.'%" AND Parrivee LIKE "%'.$arrivee.'%" AND date_t LIKE "%'.$date.'%" ');
  
}

else{
    $message = 'Veuillez remplir tous les champs';

}   
}




?>

<?php require('header_ps.php');
?>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Page Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="style_recherche.css">
   
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.0/css/all.css" integrity="sha384-Mmxa0mLqhmOeaE8vgOSbKacftZcsNYDjQzuCOm6D02luYSzBG8vpaOykv9lFQ51Y" crossorigin="anonymous">
    <link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel = "stylesheet">
</head>

<body>

    <section>
 
        <div class="barre_recherche">
    <form method="GET">
        <h2>Votre recherche de trajet aller</h2>
        <div class="depart">
            <label>Depart</label>
            <div class="ch">
        <select name="depart" class="cntrl">
        <option></option>

 <option>Tunis</option>
   <option>Sfax</option>
   <option>Sousse</option>
   <option>Kairouan </option>
   <option>Bizerte </option>
   <option>Gabes </option>
   <option>Ariana </option>
   <option> Gafsa</option>
   <option>Monastir </option>
   <option>Ben Arous </option>
   <option>Kasserine </option>
   <option>Médenine </option>
   <option> Nabeul</option>
   <option>Tataouine </option>
   <option> Beja</option>
   <option>Le Kef </option>
   <option>Mahdia </option>
   <option>Sidi Bouzid </option>
   <option>Jendouba </option>
   <option>Tozeur </option>
   <option>La Manouba </option>
   <option>Siliana </option>
   <option> Zaghouan</option>
   <option> Kébili</option>


        </select>
</div>
</div>
<div class="arrivee">
<label>Arrivée</label>
<div class="ch">

        <select name="arrivee" class="cntrl">
        <option></option>

 <option>Tunis</option>
   <option>Sfax</option>
   <option>Sousse</option>
   <option>Kairouan </option>
   <option>Bizerte </option>
   <option>Gabes </option>
   <option>Ariana </option>
   <option> Gafsa</option>
   <option>Monastir </option>
   <option>Ben Arous </option>
   <option>Kasserine </option>
   <option>Médenine </option>
   <option> Nabeul</option>
   <option>Tataouine </option>
   <option> Beja</option>
   <option>Le Kef </option>
   <option>Mahdia </option>
   <option>Sidi Bouzid </option>
   <option>Jendouba </option>
   <option>Tozeur </option>
   <option>La Manouba </option>
   <option>Siliana </option>
   <option> Zaghouan</option>
   <option> Kébili</option>


        </select>
</div>
</div>

<div class="date">
<label>Date</label>
<div class="ch">

        <input type="date" name="date" class="cntrl" />
</div>

</div>       
<span class="msg" > <?php if(isset($message)) { echo $message; } ?></msg>

<input type="submit" value="Rechercher" class="btn">

        </form>
</div>



<div class="cadre">
<?php if($trajet->rowCount() > 0) {   ?>
   
   <ul>
   <?php while($a = $trajet->fetch()) { ?>
   
      <li>
          <div class="tt">
      <a href="liste trajet.php?idt=<?= $a['id_trajet'] ?>&id=<?= $_SESSION['id'] ?>">

              <div class="heure-date">
          <span class="heure"><?= $a['heure_t'] ?></span>
          <span class="date"><?= $a['date_t'] ?></span>
      </div>

      <div class="trajet">

        <div class="icon">
        <span class="caricons"><i class="fas fa-map-marker-alt"></i></span>
          <span class="caricons"><i class="fas fa-arrow-right"></i></span>

        </div>
        <div class="destination">
        <div class="depart"><strong><?= $a['Pdepart'] ?></strong></div>
        <div class="depart"><strong><?= $a['Parrivee'] ?></strong></div>
        </div>

      </div>

      <div class="place-prix">

        <div class="place">
          <span><strong><?= $a['place_disponible'] ?> places</strong></span>
        </div>

        <div class="prix">
        <span><strong><?= $a['prix_t'] ?> DT</strong></span>
        </div>

      </div>


      </a>
   </div>
      </li>



   <?php } ?>
   </ul>
<?php } else {?>

<span class="msge">Pour le moment,
aucune annonce ne correspond à votre recherche.</span>
<?php } ?>


</div>
</section>

</body>
</html>