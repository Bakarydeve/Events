
<li><a href="redacteur_accueil.php">Accueil & Mon profil </a>
<li><a href="redacteur_url.php">Gestion des URL </a>

<?php 
//Ouverture d'une session
session_start();
//Affectation dans des variables du pseudo/mot de passe s'ils existent, affichage d'un message sinon
if ($_POST["numero"])	{
	$id=htmlspecialchars(addslashes($_POST["numero"]));
}
else
{
	echo("Veuillez remplir le champs");
}

	$mysqli = new mysqli('localhost','zberteba0','t54kv87z','zfl2-zberteba0');
	if ($mysqli->connect_errno)	{
		// Affichage d'un message d'erreur
		echo "Error: Problème de connexion à la BDD \n";
		echo "Errno: " . $mysqli->connect_errno . "\n";
		echo "Error: " . $mysqli->connect_error . "\n";
		// Arrêt du chargement de la page
		exit();
	}
	//echo ("Connexion BDD réussie !");
	echo "<br />";
	// Instructions PHP à ajouter pour l'encodage utf8 du jeu de caractères
	if (!$mysqli->set_charset("utf8")) {
		printf("Pb de chargement du jeu de car. utf8: %s\n", $mysqli->error);
		exit();
	}

	// Requete pour ajouter un lien dans la table url
	$requete = "DELETE from t_url_url where url_id = '" .$id. "';";
    // Affichage de la requete
	//echo $requete;
	//Exécution de la requête d'ajout d'un compte dans la table des comptes
	$resultat = $mysqli->query($requete);

	if ($resultat == false)	{ //Erreur lors de l’exécution de la requête
		// La requête a echoué
		echo "Error: La requête a échoué  \n";
		echo "Query: " . $sql . "\n";
		echo "Errno: " . $mysqli->errno . "\n";
		echo "Error: " . $mysqli->error . "\n";
		exit;
	}
	else
	{
		echo("Le lien à bien été supprimer");
	}

//Ferme la connexion avec la base MariaDB
$mysqli->close();
?>