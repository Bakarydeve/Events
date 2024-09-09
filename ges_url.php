<?php 
//Ouverture d'une session
session_start();

if(!isset($_SESSION['login']) && !isset($_SESSION['statut']))	{
	//Si la session n'est pas ouverte, redirection vers la page du formulaire
	header("Location:session.php");
	exit();
}
?>

<?php
//header("refresh:5;url=gestionnaire_comptes.php");
/* Code PHP permettant d’afficher le détail du profil de l’utilisateur connecté */

     $mysqli = new mysqli('localhost','zberteba0','t54kv87z','zfl2-zberteba0');
     if ($mysqli->connect_errno) 
     {
     	// Affichage d'un message d'erreur
     	echo "Error: Problème de connexion à la BDD \n";
     	echo "Errno: " . $mysqli->connect_errno . "\n";
     	echo "Error: " . $mysqli->connect_error . "\n";
     	// Arrêt du chargement de la page
     	exit();
     }
     // Instructions PHP à ajouter pour l'encodage utf8 du jeu de caractères
     if (!$mysqli->set_charset("utf8")) {
     	printf("Pb de chargement du jeu de car. utf8: %s\n", $mysqli->error);
     	exit();
     }

     $sql="SELECT * from t_url_url";
     //echo $sql;
     echo "<br />";

     $result= $mysqli->query($sql);

	if ($result==false) {
 		// La requête a echoué
		echo "Error: La requête a echoué  \n";
    	echo "Errno: " . $mysqli->errno . "\n";
    	echo "Error: " . $mysqli->error . "\n";
     		
 		exit();
	}
	else //La requête s’est bien exécutée (<=> couleur verte dans phpmyadmin)
	{
		//echo "<br />";
		//echo($resultat->num_rows); //Donne le bon nombre de lignes récupérées
		//echo "<br />";
		while ($lien = $result->fetch_assoc())	{
		echo ($lien['url_nom'] . ' ' . $lien['url_chaine']);
		echo "<br />";
	}

}
//Ferme la connexion avec la base MariaDB
$mysqli->close();

?>