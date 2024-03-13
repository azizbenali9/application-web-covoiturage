
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

if(isset($_POST['Pdepart'], $_POST['Parrivee'], $_POST['date_t'], $_POST['heure_t'], $_POST['bagage'], $_POST['fumeur'], $_POST['music'], $_POST['place_disponible'], $_POST['prix_t'], $_POST['mot'])) {
   if(!empty($_POST['Pdepart']) AND !empty($_POST['Parrivee']) AND !empty($_POST['date_t']) AND !empty($_POST['heure_t']) AND !empty($_POST['bagage']) AND !empty($_POST['fumeur']) AND !empty($_POST['music']) AND !empty($_POST['place_disponible']) AND !empty($_POST['prix_t']) AND !empty($_POST['mot']) ) {
      
      $Pdepart = htmlspecialchars($_POST['Pdepart']);
      $Parrivee = htmlspecialchars($_POST['Parrivee']);
      $date_t = htmlspecialchars($_POST['date_t']);
      $heure_t = htmlspecialchars($_POST['heure_t']);
      $bagage = htmlspecialchars($_POST['bagage']);
      $fumeur = htmlspecialchars($_POST['fumeur']);
      $music = htmlspecialchars($_POST['music']);
      $place_disponible = htmlspecialchars($_POST['place_disponible']);

      $prix_t = htmlspecialchars($_POST['prix_t']);
      $mot = htmlspecialchars($_POST['mot']);

      if($mode_edition == 0) {          
         $ins = $bdd->prepare('INSERT INTO trajet (Pdepart, Parrivee, date_t, heure_t, bagage, fumeur, music, place_disponible, prix_t, mot, id_conducteur) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
         $ins->execute(array($Pdepart, $Parrivee, $date_t, $heure_t, $bagage, $fumeur, $music, $place_disponible, $prix_t, $mot, $_SESSION['id_conducteur']));
         $message = 'Votre trajet a bien été posté';


      } else {
         $update = $bdd->prepare('UPDATE trajet SET Pdepart = ?, Parrivee = ?, date_t = ?, heure_t = ?, bagage = ?, fumeur = ?, music = ?, place_disponible = ?, prix_t = ?, mot = ? WHERE id_trajet = ? AND id_conducteur = ? ');
         $update->execute(array($Pdepart, $Parrivee, $date_t, $heure_t, $bagage, $fumeur, $music, $place_disponible, $prix_t, $mot, $edit_id, $_SESSION['id_conducteur']));
         $message = 'Votre trajet a bien été mis à jour !';

         header('Location: trajet.php?id='.$edit_id);
      }
   } else {
      $message = 'Veuillez remplir tous les champs';
   }
}



?>



<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Basic</title>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.0/css/all.css" integrity="sha384-Mmxa0mLqhmOeaE8vgOSbKacftZcsNYDjQzuCOm6D02luYSzBG8vpaOykv9lFQ51Y" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
  <link rel="stylesheet" href="dist/jquery-steps.css">
  <!-- Demo stylesheet -->
  <link rel="stylesheet" href="css/style_publ.css">
</head>
<body>
<?php  include('header.php');
?>

  <div id="demo">

  <div class="AddTrip-title">
    Proposer un trajet
</div>
<form method="post" id="register_form">
    <div class="step-app">
      <ul class="step-steps">
        <li class="icon "><a href="#step1">Le trajet</a><i class="fas fa-map-marked-alt"></i></li>
        <li class="icon"><a href="#step2">Date et heure</a><i class="fas fa-clock"></i></li>
        <li class="icon"><a href="#step3">Préférences</a><i class="fas fa-suitcase-rolling"></i></li>
        <li class="icon"><a href="#step4">Places et prix</a><i class="fas fa-hand-holding-usd"></i></li>
        <li class="icon"><a href="#step5">Publication</a><i class="fas fa-user-check"></i></li>
      </ul>

      <div class="step-content">
        <div class="step-tab-panel" id="step1">
        <div class="desc">
       <div class="texte">Quel est votre trajet ?</div>
       </div>
      <div class="form">
       <div class="infro">

            <div class="text">
              <span class="icon"> <i class="fas fa-street-view"></i></span>

            <label class="Add" >Je pars de</label>
            <select name="Pdepart" <?php if($mode_edition == 1) { ?> value="<?= $edit_trajet['Pdepart'] ?>"<?php } ?> required>
 
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
           
            <div class="text">
            <span class="icon"><i class="fas fa-street-view"></i></span>

            <label class="Add" >et je vais à</label>
            <select name="Parrivee" <?php if($mode_edition == 1) { ?> value="<?= $edit_trajet['Parrivee'] ?>"<?php } ?> >
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
       
       <div class="image">
         <img src="voiture-form.png" />
       </div>

       </div>

</div>
        <div class="step-tab-panel" id="step2">
        <div class="desc">
       <div class="texte">Quand partez-vous ?</div>
       </div>
       <div class="form">
         <div class="infor">
         <div class="text">
             

            <label class="Add" >Je pars le</label>
                    <input type="date" name="date_t"   <?php if($mode_edition == 1) { ?> value="<?= $edit_trajet['date_t'] ?>"<?php } ?> >
                    <label class="Add" >a</label>
                    <input type="time" name="heure_t"  <?php if($mode_edition == 1) { ?> value="<?= $edit_trajet['heure_t'] ?>"<?php } ?> >

 </div>

         </div>
         <div class="image">
         <img src="time.png" width="100%" />
       </div>
       </div>
        </div>
        <div class="step-tab-panel" id="step3">
        <div class="desc">
       <div class="texte">Quelle taille de bagages acceptez-vous ?</div>
       </div>
       <div class="form">
         <div class="infor">
           <div class="styled-select">

               <select name="bagage" <?php if($mode_edition == 1) { ?> value="<?= $edit_trajet['bagage'] ?>"<?php } ?> > 
       <option>Petit bagage</option>
       <option>Bagage moyen</option>
       <option>Gros bagage</option>
       </select>
</div>
<div class="desc">
       <div class="texte">d'option :</div>
       </div>
       <div class="text">
        <label class="Add" >Fumeur acceptée :</label>

               <select name="fumeur" <?php if($mode_edition == 1) { ?> value="<?= $edit_trajet['fumeur'] ?>"<?php } ?> > 
       <option>Oui</option>
       <option>Non</option>

     </select>
     </div>
     <div class="text">

         <label class="Add" >Music :</label>
         <select name="music" <?php if($mode_edition == 1) { ?> value="<?= $edit_trajet['music'] ?>"<?php } ?> > 
       <option>Oui</option>
       <option>Non</option>

     </select> 
     </div>

         </div>
        
       </div>
        </div>
        <div class="step-tab-panel" id="step4">
        <div class="desc">
       <div class="texte">Je choisis le nombre de places disponibles et le prix du trajet</div>
       </div>
       <div class="form">
       <div class="infor">
       <div class="text">
             

             <label class="Add" >J'ai</label>
             <select name="place_disponible" <?php if($mode_edition == 1) { ?> value="<?= $edit_trajet['place_disponible'] ?>"<?php } ?> >
               <option>1</option>
               <option>2</option>
               <option>3</option>
               <option>4</option>

             </select>
                     <label class="Add" >place disponible dans ma voiture.</label>
  </div>
  
  <div class="prix">
  <label class="Add" >Prix par place en dinar:</label>

  <input type="number" name="prix_t" placeholder="1.0" step="0.5" min="0" max="35" <?php if($mode_edition == 1) { ?> value="<?= $edit_trajet['prix_t'] ?>"<?php } ?>>
</div>
<div class="alert">
              <span class="icon"> <i class="far fa-lightbulb"></i></span>

         <p>Vous pouvez ajouter ou modifier votre véhicule dans la rubrique "Ma voiture" dans votre profil.</p>
            </div>

         </div>
       </div>
        </div> 
         <div class="step-tab-panel" id="step5">
         <div class="desc">
       <div class="texte">Un dernier mot avant de prendre la route ? </div>
       </div>
       <div class="form">
         <div class="infor">
         <div class="area">
  <textarea name="mot" placeholder="Vos précisions (lieu de rendez-vous, ...)" <?php if($mode_edition == 1) { ?> value="<?= $edit_trajet['mot'] ?>"<?php } ?>></textarea>
</div>
<div class="paeiment">
   <span class="icon"> <i class="fas fa-credit-card"></i></span>

         <p>Tous les paiements s’effectuent en ligne et sont 100% sécurisés.</p>
            </div>

         </div>
       </div>
        </div>
        
        </div>

      <div class="step-footer">
      <span style="color: red">
      <?php if(isset($message)) { echo $message; } ?>
</span>
        <button   data-direction="prev" class="step-btn">Retour</button>
        <button   data-direction="next" class="step-btn">Contunier</button>
        <input type="submit" value="submit" name="finish" data-direction="finish" class="step-btn">
      </div>

      </div>

      </div>


  <script src="http://code.jquery.com/jquery-latest.min.js"></script>
  <script src="dist/jquery-steps.js"></script>
  <script>
    $('#demo').steps({
      onFinish: function () {
      
      }
    });
  </script>
</body>
</html>
