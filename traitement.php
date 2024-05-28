<!--Julia Tabari -->
<?php
session_start();
  $err = false;
  function verification(){
    $erreur = "";
    if($_POST['prix'] <= 0){$erreur .= "Le prix doit être strictement positif.<br><br>";
                           $err = true;}
    if($_POST['nbExemplaires'] < 1){$erreur .= "Le nombre d'exemplaires doit être strictement positif.<br><br>";
                                   $err = true;}
    if($err){
    $erreur ="<h1>Erreur : </h1><p>". $err. "</p>";}
    
    return $erreur;
  }


function titre($bool_err){
  if($bool_err){
    return "Erreur";
  }
  else{
    return "Produit ajouté !";
  }
}


?>
<!DOCTYPE html>
<html lang ="fr">
    <head>
        <meta charset ="utf-8">
        <title><?php echo titre($err) ?></title>
        <link rel="stylesheet" href="style.css">
    </head>

<body>
  
<?php include("verif_connexion_SGBD.php");
  include("config.php");
  mysqli_set_charset($connexion, 'utf8');
  $titre = mysqli_real_escape_string($connexion,$_POST['titre']);
  $auteur = mysqli_real_escape_string($connexion,$_POST['auteur']);
  $prix = $POST_['prix'];
  $genre = $POST_['genre'];
  $annee = $POST_['date'];
  $nb_ex = $POST_['nbExemplaires'];
  $id_vend = $_SESSION['id'];
  if(!$err){
    mysqli_query($connexion,"INSERT INTO produits(book_name,book_author,genre,annee_parution,prix, nombre_exemplaires,id_vendeur) VALUES($titre,$auteur,$genre, $annee,$prix, $id_vend") or die("Erroe Occured");
    $id_produit = mysqli_query($connexion, "SELECT id_prod FROM prdotuis WHERE titre = $titre AND id=$id_vend");
    $chemin_prod = 'photo_livres/' . $id_produit . ".png" ;
    $req = mysqli_query($connexion,"UPDATE chemin_photo FROM produits SET chemin_photo = $chemin_prod WHERE id_prod=$id_produit");
  }

mysqli_close($connexion);
mysqli_close($con);

?>
</body>
