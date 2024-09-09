
<li><a href="redacteur_accueil.php">Accueil & Mon profil</a>
<li><a href="redacteur_visuels.php">Gestion des visuels</a>

<?php 
//Ouverture d'une session
session_start();
//Affectation dans des variables du pseudo/mot de passe s'ils existent, affichage d'un message sinon
if ($_POST["numero"])	{
	$id=htmlspecialchars($_POST["numero"]);
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

	$requete="SELECT cpt_pseudo from t_virtuel_vir where vir_id = '" .$id. "'";

	$resultat = $mysqli->query($requete);

	$requete2="SELECT vir_visibilite from t_virtuel_vir where vir_id = '" .$id. "'";

	$sql="DELETE from t_virtuel_vir where vir_id = '" .$id. "'";

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
		if($resultat->num_rows == 1)	{
			$ligne=$resultat->fetch_assoc();
			$visuel['psdo'] = $ligne['cpt_pseudo'];
			//echo $actualite['pseudo'];
			$result = $mysqli->query($requete2);
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
				$li=$result->fetch_assoc();
				$visuel['visibilite'] = $li['vir_visibilite'];
				//echo $actualite['pseudo'];
				if($visuel['psdo'] == $_SESSION['login'])	{
					$result = $mysqli->query($sql);
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
						echo("Visuel supprimé avec succès");
						echo "<br />";
					}					
				}
					
				else
				{
					echo("Vous n'etez pas autorisé à supprimé ce visuel");
					exit;
				}

			}
		}

	}
}
	



