
<li><a href="redacteur_accueil.php">Accueil & Mon profil</a>
<li><a href="redacteur_actualite.php">Gestion des actualités</a>

<?php 
//Ouverture d'une session
session_start();
//Affectation dans des variables du pseudo/mot de passe s'ils existent, affichage d'un message sinon
if ($_POST["numero"])	{
	$id=htmlspecialchars(addslashes($_POST["numero"]));
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
	$sql = "SELECT cpt_pseudo from t_news_new where new_id = '" .$id. "';";

	$result = $mysqli->query($sql);

	// Requete pour recupere la validite du compte
	$requete = "DELETE from t_news_new where new_id = '" .$id. "' and cpt_pseudo =  '" .$_SESSION['login']. "';";
    // Affichage de la requete
	//echo $requete;
	//Exécution de la requête d'ajout d'un compte dans la table des comptes
	//$resultat = $mysqli->query($requete);

	if ($result == false)	{ //Erreur lors de l’exécution de la requête
		// La requête a echoué
		echo "Error: La requête a échoué  \n";
		echo "Query: " . $sql . "\n";
		echo "Errno: " . $mysqli->errno . "\n";
		echo "Error: " . $mysqli->error . "\n";
		exit;
	}
	else
	{
		if($result->num_rows == 1)	{
			$ligne=$result->fetch_assoc();
			$actualite['pseudo'] = $ligne['cpt_pseudo'];
			//echo $actualite['pseudo'];
			if($_SESSION['login'] != $actualite['pseudo'])	{
				echo("Vous ne pouvez supprimer que les actualités que vous avez mit en ligne");
				exit;
			}
			else
			{
				$resultat = $mysqli->query($requete);
				if ($result == false)	{ //Erreur lors de l’exécution de la requête
					// La requête a echoué
					echo "Error: La requête a échoué  \n";
					echo "Query: " . $sql . "\n";
					echo "Errno: " . $mysqli->errno . "\n";
					echo "Error: " . $mysqli->error . "\n";
					exit;
				}
				else
				{
					echo("Actualités supprimé avec succès");
				}
			}		
		}
	}