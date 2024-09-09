
<li><a href="gestionnaire_actualite.php">Actualités</a>
<li><a href="gestionnaire_accueil.php">Gestionnaire accueil</a>

<?php 
//Ouverture d'une session
session_start();
//Affectation dans des variables du pseudo/mot de passe s'ils existent, affichage d'un message sinon
if ($_POST["numero"] && $_POST["etat"])	{
	$id=htmlspecialchars(addslashes($_POST["numero"]));
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
	$requete = "SELECT new_etat from t_news_new where new_id = '" .$id. "';";
    // Affichage de la requete
	//echo $requete;
	//Exécution de la requête d'ajout d'un compte dans la table des comptes
	$resultat = $mysqli->query($requete);


	//Préparation de la requête à partir des chaînes saisies =>
	//concaténation (avec le point) des différents éléments composant la requête
	$sql="UPDATE t_news_new set new_etat = 'L' where new_id = '" .$id. "';";
	//echo $sql;
	//Exécution de la requête d'ajout d'un compte dans la table des comptes

	//Préparation de la requête à partir des chaînes saisies =>
	//concaténation (avec le point) des différents éléments composant la requête
	$sql2="UPDATE t_news_new set new_etat = 'C' where new_id = '" .$id. "';";

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
		if($resultat->num_rows == 1 )	{
			$ligne=$resultat->fetch_assoc();
			$Etat['actualite'] = $ligne['new_etat'];
			//echo $Etat['actualite'];
			if($ett == 'L' && $Etat['actualite'] == 'C')	{
				$result = $mysqli->query($sql);
				echo $result;
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
					echo("Actualité mit en ligne");
					exit;
				}

			}
			else if($ett == 'L' && $Etat['actualite'] == 'L')	{
				echo("L'actualité est déjà en ligne");
				exit;
			}
			else if($ett == 'C' && $Etat['actualite'] == 'L')	{
				$result2 = $mysqli->query($sql2);
				//echo $result2;
				if ($result2 == false)	{ //Erreur lors de l’exécution de la requête
					// La requête a echoué
					echo "Error: La requête a échoué  \n";
					echo "Query: " . $sql . "\n";
					echo "Errno: " . $mysqli->errno . "\n";
					echo "Error: " . $mysqli->error . "\n";
					exit;
				}
				else
				{
					echo("L'Actualité à été caché");
					exit;
				}

			}
			else
			{
				echo("L'actualité est déjà caché");
			}
		}
	}

//Ferme la connexion avec la base MariaDB
$mysqli->close();
?>