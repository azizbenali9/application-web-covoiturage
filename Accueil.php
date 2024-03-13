<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>CO-VOITURAGE en tunisie</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="style1.css">



    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.0/css/all.css" integrity="sha384-Mmxa0mLqhmOeaE8vgOSbKacftZcsNYDjQzuCOm6D02luYSzBG8vpaOykv9lFQ51Y" crossorigin="anonymous">
    <link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel = "stylesheet">
 <script src = "https://code.jquery.com/jquery-1.10.2.js"></script>
 <script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
 <!-- Javascript -->
 <script>
   $(function() {
      $( "#datepicker-12" ).datepicker();
      $( "#datepicker-12" ).datepicker("setDate", "10w+1");
   });
</script>
</head>
<body>
    <!--Navigation-->
    <nav class="navbar">
        <div class="logo"><a href="#">CO-VOITURAGE |<span>en tunisie</span> </a></div>
        <ul>
            <li><a href="#"><i class="fas fa-search"></i>Rechercher</a></li>
            <li><a href="#"><i class="fas fa-plus-circle"></i>Publier</a></li>
            <li><a href="#"><i class="fas fa-shopping-cart"></i>Panier</a></li>
            <li><a href="connexion.php" class="active">Connexion</a></li>
        </ul>
    </nav>
    <!--Header-->
    <div class="hed">
    <div class="container">
       <h1>Et vous, qui allez-vous retrouver ?</h1>
       <h3>Le covoiturage simplifie vos trajets</h3>
       <form>

            <i class="fas fa-map-marker-alt"><input type="text" name="depart" placeholder="Départ" required></i>
        
            <i class="fas fa-map-marker-alt"><input type="text" name="destination" placeholder="Destination" required></i>

      <i class="fas fa-calendar-alt"><input type = "text" id = "datepicker-12" placeholder="Date" required></i> 
        

           <input type="submit" value="Rechercher un trajet">
       </form>
    </div>
</div>
    
</body>
</html>