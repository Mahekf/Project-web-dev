<!--Julia Tabari-->
<?php
    session_start();
    include('config.php');
    if(isset($_POST['submit'])){
        $id_signaleur = $_SESSION['Id'];
        $id_vendeur = mysqli_query($con, "SELECT Id FROM users WHERE Email='".$_POST['seller']."'");
        $id_book = mysqli_query($con, "SELECT id_prod FROM produits WHERE id_vendeur='".$id_vendeur."' AND book_name='".$_POST['titre']."'");
        $reason = $_POST['reason'];
        mysqli_query($con, "UPDATE produits SET nb_signalement = nb_signalement+1 WHERE id='".$id_book."'"); 
        mysqli_query($con, "INSERT INTO signalements(id_livre, id_vendeur, id_signaleur, reason) VALUES('".$id_book."', '".$id_vendeur."', '".$id_signaleur."', '".$reason."')");
        
    }
?>

<!DOCTYPE html>
<html lang ="fr">
    <head>
        <meta charset ="utf-8">
        <title>Report product</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
      <form action="" method="post" enctype="multipart/form-data">
        <div class="field input">Book's name : <input name="titre" size="30"><br></div>
        <div class="field input">Author : <input name="auteur" ><br></div>
        <div class="field input">Seller's email(you can find it by clicking on it profile) : <input name="seller" ><br></div>
        <div class="field input">Reason of why this product should be deleted from the website : <input name="reason" size="200" ><br></div>
        <div class="field"><input type="submit" value="Send the report" name="go"></div>
      </form>
        
    </body>
</html>
