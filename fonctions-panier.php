<?php 
$bdd = new PDO("mysql:host=127.0.0.1;dbname=app_covoiturage;charset=utf8", "root", "");

function creationPanier(){
   if (!isset($_SESSION['panier'])){
      $_SESSION['panier']=array();
      $_SESSION['panier']['idt'] = array();
      $_SESSION['panier']['place_disponible'] = array();
      $_SESSION['panier']['prix_t'] = array();
   }
   return true;
}
function ajouterArticle($idt,$place_disponible,$prix_t){

    //Si le panier existe
    if (creationPanier() )
    {
       //Si le produit existe déjà on ajoute seulement la quantité
       $positionProduit = array_search($idt,  $_SESSION['panier']['idt']);
 
       if ($positionProduit !== false)
       {
          $_SESSION['panier']['place_disponible'][$positionProduit] += $place_disponible ;
       }
       else
       {
          //Sinon on ajoute le produit
          array_push( $_SESSION['panier']['idt'],$idt);
          array_push( $_SESSION['panier']['place_disponible'],$place_disponible);
          array_push( $_SESSION['panier']['prix_t'],$prix_t);
       }
    }
    else
    echo "Un problème est survenu veuillez contacter l'administrateur du site.";
 }
 function supprimerArticle($idt){
    //Si le panier existe
    if (creationPanier() )
    {
       //Nous allons passer par un panier temporaire
       $tmp=array();
       $tmp['idt'] = array();
       $tmp['place_disponible'] = array();
       $tmp['prix_t'] = array();
       $tmp['verrou'] = $_SESSION['panier']['verrou'];
 
       for($i = 0; $i < count($_SESSION['panier']['idt']); $i++)
       {
          if ($_SESSION['panier']['idt'][$i] !== $idt)
          {
             array_push( $tmp['idt'],$_SESSION['panier']['idt'][$i]);
             array_push( $tmp['place_disponible'],$_SESSION['panier']['place_disponible'][$i]);
             array_push( $tmp['prix_t'],$_SESSION['panier']['prix_t'][$i]);
          }
 
       }
       //On remplace le panier en session par notre panier temporaire à jour
       $_SESSION['panier'] =  $tmp;
       //On efface notre panier temporaire
       unset($tmp);
    }
    else
    echo "Un problème est survenu veuillez contacter l'administrateur du site.";
 }
     //Si le panier éxiste

 function modifierQTeArticle($idt,$place_disponible){
    //Si le panier éxiste
    if (creationPanier() && !isVerrouille())
    {
       //Si la quantité est positive on modifie sinon on supprime l'article
       if ($place_disponible > 0)
       {
          //Recharche du produit dans le panier
          $positionProduit = array_search($idt,  $_SESSION['panier']['idt']);
 
          if ($positionProduit !== false)
          {
             $_SESSION['panier']['place_disponible'][$positionProduit] += $place_disponible ;
          }
       }
       else
       supprimerArticle($idt);
    }
    else
    echo "Un problème est survenu veuillez contacter l'administrateur du site.";
 }
//
 function MontantGlobal(){
    $total=0;
    for($i = 0; $i < count($_SESSION['panier']['idt']); $i++)
    {
       $total += $_SESSION['panier']['place_disponible'][$i] * $_SESSION['panier']['prix_t'][$i];
    }
    return $total;
 }

 function isVerrouille(){
    if (isset($_SESSION['panier']) && $_SESSION['panier']['verrou'])
    return true;
    else
    return false;
 }
 function compterArticles()
{
   if (isset($_SESSION['panier']))
   return count($_SESSION['panier']['idt']);
   else
   return 0;

}
function supprimePanier(){
    unset($_SESSION['panier']);
 }
?>
