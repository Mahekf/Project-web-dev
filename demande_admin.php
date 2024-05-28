<!--Julia Tabari -->
<?php
	session_start();
  include('config.php');
	function ajouter_demande($id_demande){
		mysqli_query($con, "UPDATE users SET Demande_admin = 1 WHERE Id==". $id_demande ." AND Nb_supp = 0");
	}
?>

