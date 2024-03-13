<?php
session_start();
require('header.php');

$bdd = new PDO("mysql:host=127.0.0.1;dbname=app_covoiturage;charset=utf8", "root", "");
if(isset($_SESSION['id_conducteur']) AND !empty($_SESSION['id_conducteur'])) {

if(isset($_GET['idm']) AND $_GET['idm'] > 0) {
    $get_id = htmlspecialchars($_GET['idm']);
    $pas = $bdd->prepare('SELECT * FROM passager WHERE `id` = ? ');
    $pas->execute(array($get_id));
    if($pas->rowCount() == 1) {
       $pas = $pas->fetch();

         
            
       
      if(isset($_POST['envoi_message'])) {
        if(isset($_POST['contenu'],$_POST['objet']) AND !empty($_POST['contenu']) AND !empty($_POST['objet'])) {
            $contenu = htmlspecialchars($_POST['contenu']);
            $objet = htmlspecialchars($_POST['objet']);

            $ins = $bdd->prepare('INSERT INTO messages(id_conducteur, id_passager, contenu, objet, date_msg) VALUES (?,?,?,?,?)');
            $ins->execute(array($_SESSION['id_conducteur'], $get_id, $contenu, $objet, date("Y-m-d H:i:s")));
      $error = "Votre message a bien été envoyé !";

      }
     else {
        $error = "Veuillez compléter tous les champs";
     }
      }

} 
else {
    die('Cet profil n\'existe pas !???');
 }
}
if(isset($_GET['o']) AND !empty($_GET['o'])) {
    $o = urldecode($_GET['o']);
    $o = htmlspecialchars($_GET['o']);
    if(substr($o,0,3) != 'RE:') {
       $o = $o;
    }}
else {
    die('erreur');
 
 }
 
   ?>

   <html>
   <head>
      <title>Envoi de message</title>
      <meta charset="utf-8" />
      <style>
      
      .section{
   background-color: #fff;
   padding: 1em;
    width:35%;
    margin: 80px auto;
}
textarea{
   width: 100%;
    height: 7em;
    margin-bottom: 0.6em;
}
input[type=submit]{
   width: 100%;
    border: none;
    /* content: close-quote; */
    padding: 6px 0px 6px 0px;
    color: #fff;
    background: #1da1f2;
}
</style>
   </head>
   <body>
   <div class="section">
   <div class="reaction">


      <form method="POST">
      
      <label>Objet:</label>
        <input type="text" name="objet" <?php if(isset($o)) { echo 'value="'.$o.'"'; } ?> />
     </div>
     <div>

         <textarea placeholder="Votre message" name="contenu"></textarea>
         </div>

         <div>

         <input type="submit" value="Envoyer" name="envoi_message" />

         </div>

         <?php if(isset($error)) { echo '<span style="color:red">'.$error.'</span>'; } ?>
      </form>
   </body>
   </html>
<?php
}
?>