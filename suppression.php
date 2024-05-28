<!--Ghanem Zahra-->


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="suppression.css">
</head>
<body>
    <div class="container">
        
        <table>
            <tr id="items">
                <th>Id</th>
                <th>Name</th>
                <th>Email</th>
                <th>Supprimer</th>
            </tr>
            <?php 
                //inclure la page de connexion
                include_once "config.php";
                //requête pour afficher la liste des employés
                $req = mysqli_query($con , "SELECT * FROM users ");
                if(mysqli_num_rows($req) == 0){
                    //s'il n'existe pas d'employé dans la base de donné , alors on affiche ce message :
                    echo "Il n'y a pas encore d'employé ajouté !" ;
                    
                }else {
                    //si non , affichons la liste de tous les employés
                    while($row=mysqli_fetch_assoc($req)){
                        ?>
                        <tr>
                            <td><?=$row['Id']?></td>
                            <td><?=$row['Username']?></td>
                            <td><?=$row['Email']?></td>
                            <!--Nous alons mettre l'id de chaque employé dans ce lien -->
                            <td><a href="supprime.php?id=<?=$row['Id']?>"><img src="images/trash.png"></a></td>
                        </tr>
                        <?php
                    }
                    
                }
            ?>
      
        <a href="index2.php">Home Page</a>
        </table>
   
   
   
   
    </div>
</body>
</html>