
<li><a href="redacteur_accueil.php">Accueil & Mon profil</a>
<li><a href="redacteur_actualite.php">Gestion des actualités</a>

<?php 
//Ouverture d'une session
session_start();
//Affectation dans des variables du pseudo/mot de passe s'ils existent, affichage d'un message sinon
if ($_POST["titre"] && $_POST["texte"] && $_POST["etat"])	{
	$actualite=htmlspecialchars(addslashes($_POST["titre"]));
	$chaine=htmlspecialchars(addslashes($_POST["texte"]));
	$ett=htmlspecialchars(addslashes($_POST["etat"]));
}
else
{
	echo("Veuillez remplir les champs");
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

	// Requete pour recupere la validite du compte
	$requete = "INSERT into t_news_new values(NULL,'" .$actualite. "','" .$chaine. "',Now(),'" .$ett. "','" .$_SESSION['login']. "');";
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
		//header("redacteur_actualite.php");
		echo("Actualité ajouté avec succès");
		exit;
	}