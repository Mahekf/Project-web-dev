<!--Ghanem Zahra-->

<?php 
   session_start();
   include_once "con_dbb.php";

   //supprimer les produits
   //si la variable del existe
   if(isset($_GET['del'])){
    $id_del = $_GET['del'] ;
    //suppression
    unset($_SESSION['tard'][$id_del]);
   }
   if (!isset($_SESSION['tard'])) {
    $_SESSION['tard'] = array();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="panier">
    <a href="index2.php" class="link">Boutique</a>
    <section>
        <table>
            <tr>
                <th></th>
                <th>Nom</th>
                <th>Prix</th>
                <th>Quantité</th>
                <th>Action</th>
            </tr>
            <?php 
              $total = 0 ;
              // liste des produits
              //récupérer les clés du tableau session
              $ids = array_keys($_SESSION['tard']);
              //s'il n'y a aucune clé dans le tableau
              if(empty($ids)){
                echo "C'est vide";
              }else {
                //si oui 
                $products = mysqli_query($con, "SELECT * FROM products WHERE id IN (".implode(',', $ids).")");

                //lise des produit avec une boucle foreach
                foreach($products as $product):
                    //calculer le total ( prix unitaire * quantité) 
                    //et aditionner chaque résutats a chaque tour de boucle
                    $total = $total + $product['price'] * $_SESSION['tard'][$product['id']] ;
                ?>
                <tr>
                    <td><img src="project_images/<?=$product['img']?>"></td>
                    <td><?=$product['name']?></td>
                    <td><?=$product['price']?>€</td>
                    <td><?=$_SESSION['tard'][$product['id']] // Quantité?></td>
                    <td><a href="tard.php?del=<?=$product['id']?>"><img src="delete.png"></a></td>
                </tr>

            <?php endforeach ;} ?>

            <tr class="total">
                <th>Total : <?=$total?>€</th>
            </tr>
        </table>
    </section>
</body>
</html>