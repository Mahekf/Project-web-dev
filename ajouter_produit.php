<!-- Ghanem Zahra-->

<?php
  if(isset($_POST['btn-ajouter'])){
      //connexion à la base de données
      $con = mysqli_connect("localhost","root","","projet");
      //recupération des données du formulaire
      $titre = $_POST['titre'];
      $prix = $_POST['prix'];
      if(!empty($titre) && !empty($prix)){
          //verifier si le produit existe déjà dans la base de données
          $req1 = mysqli_query($con, "SELECT name,price FROM products WHERE name ='$titre' AND price = '$prix' ");
          if(mysqli_num_rows($req1) > 0) {
              //si le produit existe déjà:
              $message = '<p style="color:red" >Le livre existe déjà</p>';
          }else {
              //sinon
              if(isset($_FILES['image'])){
                  //si une image a été télécharger:
                  $img_nom = $_FILES['image']['name']; //On récupère le nom de l'image 
                  $tmp_nom = $_FILES['image']['tmp_name']; //Nous définissons un nom temporaire
                  $time =time(); //On recupere l'heure actuelle
                  //On renomme l'image

                  $nouveau_nom_img = $time.$img_nom ;

                  //On déplace l'image dans le dossier project_images

                  $deplacer_image = move_uploaded_file($tmp_nom,"project_images/".$nouveau_nom_img) ;

                  if($deplacer_image){
                      //si l'image a été déplacé :
                      //insérons le titre ,la description  et le nom de l'image dans la base de donnée 
                      $req2 = mysqli_query($con,"INSERT INTO products VALUES (NULL,'$nouveau_nom_img','$prix','$titre')") ;
                       if($req2){
                           //si les informations ont été inséré dans la base de données
                           $message = '<p style="color:green">livre ajouté ! </p>';
                       }else {
                           //si non
                           $message = '<p style="color:red ">livre Non ajouté !</p>';
                       }
                  }

              }
          }
      }else {
          //si tous les champs ne sont pas remplie on a :
        $message = '<p style="color:red">Veuillez remplir tous les champs !</p>';
      }
  }


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PRODUITS GESTION</title>
    <link rel="stylesheet" href="style1.css">
</head>
<body>
    <section class="input_add">
        <form action="" method="POST" enctype="multipart/form-data">
           <div class="message">
               <?php 
               if(isset($message)){
                   //si la variable message existe , on affiche le contenu de la variable
                   echo $message ;
               }

                   ?>
           </div>
            <label>Nom du livre</label>
            <input type="text" name="titre">
            <label>Prix du livre</label>
            <input type="text" name="prix">
            <label>Ajouter un livre</label>
            <input type="file" name="image">
            <input type="submit" value="Ajouter" name="btn-ajouter">
            <a class="btn-liste-prod" href="index2.php"> Liste des livres</a>
        </form>
    </section>
</body>
</html>