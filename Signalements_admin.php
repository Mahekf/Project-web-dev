<!--Julia Tabari-->

<?php
  session_start();
  include("config.php");
  function Supprimer($id_book){
    $vendeur = mysqli_fetch_assoc(mysqli_query($con ,"SELECT id_vendeur FROM produit WHERE id='". id_book."'"));
    mysqli_query($con, "UPDATE users SET Nb_signalement=Nb_signalement + 1 AND Administrateur = 0 WHERE Id='". $vendeur['id_vendeur'] ."'");//enleve le statut d'administrateur à l'utilisateur dont le produit a été supprimé
    mysqli_query($con, "DELETE FROM produit WHERE id='" . $id_book . "'");
    supp_signalement($id_book);
  }

function supp_signalement($id_book){
  mysqli_query($con, "DELETE FROM signalements WHERE id_livre='" . $id_book . "'");
}


  function affiche_signalement(){
    $affiche_s = "<table border='1'><tr><th>Seller's email</th><th>Book</th><th>Reasons</th><th></th</tr>";
    $recuperation_prod = mysqli_query($con, "SELECT (id, book_name, id_vendeur) FROM produits WHERE nb_signalement >2"); //on considère qu'à partir de 3 signalements on traîte la demande
    $ligne = mysqli_fetch_assoc($recuperation_prod);
    while($ligne){
      $id_livre = $ligne['id'];
      $id_vendeur = $ligne['id_vendeur'];
      $nom_livre = $ligne['book_name'];
      $recup_raisons = mysqli_query($con, "SELECT reason FROM signalements WHERE id_livre='".$id_livre."'");
      $recup_email_vendeur = mysqli_fetch_assoc(mysqli_query($con, "SELECT Email FROM users WHERE Id='". $id_vendeur ."'"));
      $email = $recup_email_vendeur['Email'];
      $liste_raisons = "<ul>";
      $ligne_raison = mysqli_fetch_assoc($recup_raisons);
      while($ligne_raison){
        $liste_raisons .= "<li>". $ligne_raison['reason'] . "</li>";
        $ligne_raison =  mysqli_fetch_assoc($recup_raisons);
      }
      $liste_raison .= "</ul>";
      $affiche_s .=  "<tr><td>".$email."</td><td>" . $nom_livre . "</td><td>" . $liste_raisons . "</td><button type='button' onclick='<? php Supprimer(". $id_livre .")?>'> Supprimer le livre</button><button type='button' onclick='<?php supp_signalement(".$id_livre.")?>'> Supprimer le signalement</button>"."</tr>";
    }
    $affiche_s .= "</table>";
    return $affiche_s;
  }
?>

