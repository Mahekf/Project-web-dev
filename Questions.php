<!--Mahek Fatma-->
<meta charset="utf-8" />
<?php


/* La base des données via MySQL : La table 'espace_questions' possédants les colonnes 'id_question', 'pseudo', id_articles', 'questions' pour stocker les informations des questions. */


/*$bdd = new PDO('mysql: host=127.0.0.1;dbname=espace_questions; charset=utf8', 'root',''); /* Lien avec la base de données */

$bdd = new PDO('mysql: host=127.0.0.1;dbname=espace_questions;charset=utf8', 'root','');   



if(isset($_GET['id']) AND !empty($_GET['id'])) { /* Vérifie la variable $_GET pour récupérer l'ID de l'article */
    $getid = htmlspecialchars($_GET['id']); /* Petite sécurisation de la variable $_GET */

    /* Permet de récupérer tous les articles dans la table -- MySQL */
    $article = $bdd->prepare('SELECT * FROM articles WHERE id = ?'); 
    $article->execute(array($getid)); 
    $article = $artcle->fetch();  

    /* Vérifie si une questions est soumis */
    if($_POST['submit_question']) {

        /* Vérifie les données saisies dans le formualire -- Vérifie si les champs pseudo et question ont été envoyé via la méthode POST du formulaire */
        if(isset($_POST['pseudo'], $_POST['question']) AND !empty($_POST['pseudo']) AND !empty($_POST['question'])) { /* La méthode isset() vérifie si ces varibales existes + définies & la méthode empty() vérifie si le champs pseudo et  questions ne sont pas vide */
            $pseudo = htmlspecialchars($_POST['pseudo']); /* Pour sécuriser les données */
            $questions = htmlspecialchars($_POST['question']); 
            
            if(strlen($pseudo) < 15) { /* Vérifie la longeur de pseudo */
               $ins = $bdd->prepare('INSERT INTO  question (pseudo, question, id_article) VALUES (?;?,?, NOW())'); 
               $ins->execute((array($pseudo, $questions, $getid))); 
               $c_msg = "<span style='color:green'>Your comment has been posted, thank you !"; /* Un msg en vert est sur l'écran si le commentaire a été bien enregistrer */
            } else {
                $c_msg = "<span style='color:red'>The pseudo must be less than 15 caracters"; /* Sinon, un msg d'erreur en rouge pour la rectifier */
            }
        } else {
                $c_msg = "<span style='color:red'>The form is uncompleted"; /* Sinon, un msg d'erreur en rouge pour la rectifier */
        }
    }
}

/* On récupère les questions et on les affiche en ordre */
$_questions = $bdd->prepare('SELECT * FROM questions WHERE id_article = ? ORDER BY id DESC'); 
$_questions->execute(array($getid));
?>

<!-- Afficher l'article dont on pose la question sur -->
<h2>Questions about the books</h2>
<p> <?= $article['contenu'] ?> </p>
<br/>

<!-- Formulaire pour poster une question -->
<h2><Questions : ></h2>
 <form method="POST">
<input type="text" name="pseudo" placeholder="Your pseudo" /><br/>
<textarea name= "questions" placeholder="Your question"></textarea><br/>
<input type="submit" value="Ask my question" name="submit_question" />
</form>


<!-- Si y a des erreurs -->
 <?php
if (isset($_error)) {
    echo "Error :" .$c_error;  
} 
?>
<br/>

<!-- Afficher les questions -->
<?php while($c = $_questions->fetch()) { ?>
    <br>  <?=$c['pseudo'] ?>:</br> <?=$c['question'] ?><br/> 
<?php } ?>
