<!--Mahek Fatma-->
<meta charset="utf-8" />
<?php


/* La base des données via MySQL : La table 'espace_commenatires' possédants les colonnes 'id_comments', 'pseudo', id_articles', 'comments' pour stocker les informations des commentaires. */


/*$bdd = new PDO('mysql: host=127.0.0.1;dbname=espace_commentaires; charset=utf8', 'root',''); /* Lien avec la base de données */

$bdd = new PDO('mysql: host=127.0.0.1;dbname=espace_commentaires;charset=utf8', 'root','');   



if(isset($_GET['id']) AND !empty($_GET['id'])) { /* Vérifie la variable $_GET pour récupérer l'ID de l'article */
    $getid = htmlspecialchars($_GET['id']); /* Petite sécurisation de la variable $_GET */

    /* Permet de récupérer tous les artcles dans la table -- MySQL */
    $article = $bdd->prepare('SELECT * FROM articles WHERE id = ?'); 
    $article->execute(array($getid)); 
    $article = $artcle->fetch();  

    /* Vérifie si un commentaire est soumis */
    if($_POST['submit_comment']) {

        /* Vérifie les données saisies dans le formualire -- Vérifie si les champs pseudo et comment ont été envoyé via la méthode POST du formulaire */
        if(isset($_POST['pseudo'], $_POST['comment']) AND !empty($_POST['pseudo']) AND !empty($_POST['comment'])) { /* La méthode isset() vérifie si ces varibales existes + définies & la méthode empty() vérifie si le champs pseudo et comments ne sont pas vide */
            $pseudo = htmlspecialchars($_POST['pseudo']); /* Pour sécuriser les données */
            $comment = htmlspecialchars($_POST['comment']); 
            
            if(strlen($pseudo) < 15) { /* Vérifie la longeur de pseudo */
               $ins = $bdd->prepare('INSERT INTO comments (pseudo, comment, id_article) VALUES (?;?,?, NOW())'); 
               $ins->execute((array($pseudo, $comment, $getid))); 
               $c_msg = "<span style='color:green'>Your comment has been posted, thank you !"; /* Un msg en vert est sur l'écran si le commentaire a été bien enregistrer */
            } else {
                $c_msg = "<span style='color:red'>The pseudo must be less than 15 caracters"; /* Sinon, un msg d'erreur en rouge pour la rectifier */
            }
        } else {
                $c_msg = "<span style='color:red'>The form is uncompleted"; /* Sinon, un msg d'erreur en rouge pour la rectifier */
        }
    }
}

/* On récupère les commentaires et on les affiche en ordre */
$_comments = $bdd->prepare('SELECT * FROM comments WHERE id_article = ? ORDER BY id DESC'); 
$_comments->execute(array($getid));
?>

<!-- Afficher l'article -->
<h2>ARTICLE</h2>
<p> <?= $article['contenu'] ?> </p>
<br/>

<!-- Formulaire pour poster un commentaire -->
<h2><Comments : ></h2>
 <form method="POST">
<input type="text" name="pseudo" placeholder="Votre pseudo" /><br/>
<textarea name= "comments" placeholder="Your comments"></textarea><br/>
<input type="submit" value="Post my comment" name="submit_comment" />
</form>


<!-- Si y a des erreurs -->
 <?php
if (isset($_error)) {
    echo "Error :" .$c_error;  
} 
?>
<br/>

<!-- Afficher les commentaires -->
<?php while($c = $_comments->fetch()) { ?>
    <br>  <?=$c['pseudo'] ?>:</br> <?=$c['comment'] ?><br/> 
<?php } ?>

