<?php
$bdd = new PDO('mysql:host=127.0.0.1;dbname=app_covoiturage', 'root', '');

if(isset($_GET['id']) AND $_GET['id'] > 0) {
    $getid = intval($_GET['id']);
    $requser = $bdd->prepare('SELECT * FROM passager WHERE id = ?');
    $requser->execute(array($getid));
    $userinfo = $requser->fetch();

  
?>

<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>CO-VOITURAGE en tunisie</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" type="text/css" media="screen" href="style_pr.css">

    <link rel="stylesheet" type="text/css" media="screen" href="msg.css">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.0/css/all.css" integrity="sha384-Mmxa0mLqhmOeaE8vgOSbKacftZcsNYDjQzuCOm6D02luYSzBG8vpaOykv9lFQ51Y" crossorigin="anonymous">
    <link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel = "stylesheet">
 <script src = "https://code.jquery.com/jquery-1.10.2.js"></script>
 <script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

</head>
<body>
  
    <!--Navigation-->
    <nav class="navbar">
        <div class="logo"><a href="#">CO-VOITURAGE |<span>en tunisie</span> </a></div>
        <ul>
        <li><a href="rechercher.php?id=<?= $_SESSION['id'] ?>"><i class="fas fa-search"></i> Rechercher un trajet</a></li>
            <div class="dropdown">
            <div class="avatar">
            <?php
         if(!empty($userinfo['avatar']))
         {
         ?>
              <a href="profil_passager.php?id=<?= $_SESSION['id'] ?>">   <img src="passagers/avatars/<?php echo $userinfo['avatar']; ?>" /></a>


         <?php
      }
         ?>
    <span > Bienvenue</span> <span class="hello"> <?php echo $userinfo['pseudo']; ?> <i class="fas fa-angle-down"> </i></span> 
  </div>
    <div class="dropdown-content">
    <?php
         if(isset($_SESSION['id']) AND $userinfo['id'] == $_SESSION['id']) {
            ?>
      <a href="#">Link 1</a>
      <a href="edition_pr_passager.php">Editer mon profil</a>
      <a href="deconnexion.php">Se déconnecter</a>
    </div>
  </div> 
        </ul>
        <?php
            }
         ?>
    </nav>
    <?php
            }
         ?>
         </body>
         </html>