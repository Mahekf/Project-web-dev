<!--Ghanem Zahra-->

<?php 
include_once "con_dbb.php";
 session_start() ;
 if(!isset($_SESSION['tard'])){
    $_SESSION['tard'] = array();
 }
 $user_id = $_SESSION['user_id'];

 if(!isset($user_id)){
    header('location:index1.php');
}

if(isset($_POST['add_to_cart'])){

   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_image = $_POST['product_image'];
   $product_quantity = $_POST['product_quantity'];

   $select_cart = mysqli_query($con, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

   if(mysqli_num_rows($select_cart) > 0){
      $message[] = 'product already added to cart!';
   }else{
      mysqli_query($con, "INSERT INTO `cart`(user_id, name, price, image, quantity) VALUES('$user_id', '$product_name', '$product_price', '$product_image', '$product_quantity')") or die('query failed');
      $message[] = 'product added to cart!';
   }

};

if(isset($_POST['update_cart'])){
   $update_quantity = $_POST['cart_quantity'];
   $update_id = $_POST['cart_id'];
   mysqli_query($con, "UPDATE `cart` SET quantity = '$update_quantity' WHERE id = '$update_id'") or die('query failed');
   $message[] = 'cart quantity updated successfully!';
}

if(isset($_GET['remove'])){
   $remove_id = $_GET['remove'];
   mysqli_query($con, "DELETE FROM `cart` WHERE id = '$remove_id'") or die('query failed');
   header('location:index2.php');
}
  
if(isset($_GET['delete_all'])){
   mysqli_query($con, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
   header('location:index2.php');
}


?>

<?php 
//fonction de recherche
//include_once "con_dbb.php";
$allusers = mysqli_query($con, 'SELECT * FROM products ORDER BY id DESC');

if (isset($_GET['s']) && !empty($_GET['s'])){
    $recherche = htmlspecialchars($_GET['s']);
    $allusers = mysqli_query($con, 'SELECT * FROM products WHERE name LIKE "%'.$recherche.'%" ORDER BY id DESC');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boutique</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php
if(isset($message)){
   foreach($message as $message){
      echo '<div class="message" onclick="this.remove();">'.$message.'</div>';
   }
}
?>

    <form method="GET" class="search-form">
        <input type="search" name="s" placeholder="rechercher" class="search-input">
        <input type="submit" name="envoyer" class="search-button"> 

    </form>

    <!-- afficher le nombre de produit dans le panier -->
    <a href="tard.php" class="link">Tard<span><?=array_sum($_SESSION['tard'])?></span></a>
    <?php
    if($_SESSION['type_compte'] === 'vendeur') {
    echo '<a href="ajouter_produit.php" class="link">Ajouter un livre</a>';
}
?>

    <a href="logout.php" class="link">Log out</a>
<?php
    if($_SESSION['type_compte'] === 'administrateur') {
    echo '<a href="suppression.php" class="link">Supprimer des comptes</a>';
}
?>

    <section class="products_list">
    <?php 
    if (mysqli_num_rows($allusers) > 0){
        while($user = mysqli_fetch_assoc($allusers)){?>
            <form method ="post" action="" class="product">
                <div class="image_product">
                    <img src="project_images/<?=$user['img']?>">
                </div>
                <div class="content">
                    <h4 class="name"><?=$user['name']?></h4>
                    <h2 class="price"><?=$user['price']?>€</h2> 
                    <input type="number" min="1" name="product_quantity" value="1">
                    <input type="hidden" name="product_image" value="<?php echo $user['img']; ?>">
                     <input type="hidden" name="product_name" value="<?php echo $user['name']; ?>">
                     <input type="hidden" name="product_price" value="<?php echo $user['price']; ?>">
                    <input type = "submit" value = "add to cart " name = "add_to_cart" class="id_product">                                                                                                          <br> <br> <br>
                    <a href="ajouter_tard.php?id=<?=$user['id']?>" class="id_product">Pour plus_tard</a>
                </div>
            </form>
    
    <?php } 
    }
    else{  ?>
        <p>Aucun produit trouvé</p>
    <?php
    }
    ?>
    </section>



<div class="shopping-cart">

<h1 class="heading">shopping cart</h1>

<table>
   <thead>
      <th>image</th>
      <th>name</th>
      <th>price</th>
      <th>quantity</th>
      <th>total price</th>
      <th>action</th>
   </thead>
   <tbody>
   <?php
      $cart_query = mysqli_query($con, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
      $grand_total = 0;
      if(mysqli_num_rows($cart_query) > 0){
         while($fetch_cart = mysqli_fetch_assoc($cart_query)){
   ?>
      <tr>
         <td><img src="images/<?php echo $fetch_cart['image']; ?>" height="100" alt=""></td>
         <td><?php echo $fetch_cart['name']; ?></td>
         <td>$<?php echo $fetch_cart['price']; ?>/-</td>
         <td>
            <form action="" method="post">
               <input type="hidden" name="cart_id" value="<?php echo $fetch_cart['id']; ?>">
               <input type="number" min="1" name="cart_quantity" value="<?php echo $fetch_cart['quantity']; ?>">
               <input type="submit" name="update_cart" value="update" class="option-btn">
            </form>
         </td>
         <td>$<?php echo $sub_total = ($fetch_cart['price'] * $fetch_cart['quantity']); ?>/-</td>
         <td><a href="index2.php?remove=<?php echo $fetch_cart['id']; ?>" class="delete-btn" onclick="return confirm('remove item from cart?');">remove</a></td>
      </tr>
   <?php
      $grand_total += $sub_total;
         }
      }else{
         echo '<tr><td style="padding:20px; text-transform:capitalize;" colspan="6">no item added</td></tr>';
      }
   ?>
   <tr class="table-bottom">
      <td colspan="4">grand total :</td>
      <td>$<?php echo $grand_total; ?>/-</td>
      <td><a href="index2.php?delete_all" onclick="return confirm('delete all from cart?');" class="delete-btn <?php echo ($grand_total > 1)?'':'disabled'; ?>">delete all</a></td>
   </tr>
</tbody>
</table>

<div class="cart-btn">  
   <a href="#" class="btn2 <?php echo ($grand_total > 1)?'':'disabled'; ?>">proceed to checkout</a>
</div>

</div>
         
</body>
</html>