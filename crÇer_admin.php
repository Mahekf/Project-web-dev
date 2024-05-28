<!--Julia Tabari-->
<?php
	session_start();
	include_once("config.php");
	
	$connex = mysqli_connect("localhost","root","","base_projet") or die("Couldn't connect"); //connexion pour la base des commentaires


	function Supp($id_demande){
		mysqli_query($con, "UPDATE users SET Demande_admin = 0 WHERE Id=='".$id_demande."'");
	}

	function Ajout($id_demande){
		mysqli_query($con, "UPDATE users SET Administrateur = 1 WHERE Id=='".$id_demande."'");
		Supp($id_demande); //supprime l'utilisateur ajouté des demandes
		
	}
	function affiche_demande(){
		$affiche = "<table border='1'><tr><th>Email</th><th>Pseudo</th><th>Number of deleted products</th><th>Number of posted comments</th><th></th</tr>";
		$requ = mysqli_query($con, "SELECT(Id,Email, Username, Nb_supp) FROM users WHERE Demande_admin = '1'") or die(Erreur);//selectionne les profils des utilisateurs ayant demandé à être administrateur
		$res = mysqli_fetch_assoc($requ);
		while($res){
			//recuperation des données
			$req_com = mysqli_query($connex, "SELECT pseudo FROM espace_commentaire WHERE pseudo == '".$res['Username']."'");
			$nb_commentaires = mysqli_num_rows($req_com);
			$affiche .= "<tr><td>".$res['Email'] . "</td><td>" . $res['Username'] . "</td><td>". $res['Nb_supp']. "</td><td>" . $nb_commentaires ."</td><td><button type='button' onclick='" . <? php Supp($res['Id'])?>."'> Supprimer</button><button type='button' onclick='".<? php Ajout($res['Id'])?>."'> Ajouter en administrateur</button></td></tr>" ; 
			$res = mysqli_fetch_assoc($requ);//ligne suivante récupérée
		}
		$affiche .= "</table>";
		return $affiche;
	}
	

?>

<!DOCTYPE html>
<html lang ="fr">
    <head>
        <meta charset ="utf-8">
        <title>Applications for administrator</title>
        <link rel="stylesheet" href="style.css">
    </head>

<body>
  
<?php
	echo affiche_demande();
mysqli_close($con);

?>
</body>
