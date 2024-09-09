
<li><a href="redacteur_accueil.php">Accueil & Mon profil</a>
<li><a href="redacteur_categories.php">Gestion des catégories</a>

<?php 
//Ouverture d'une session
session_start();
//Affectation dans des variables du pseudo/mot de passe s'ils existent, affichage d'un message sinon
if ($_POST["numero"] &&  $_POST["catnum"] && $_POST["etat"])	{
	$id=htmlspecialchars($_POST["numero"]);
	$idcat=htmlspecialchars($_POST["catnum"]);
	$ett=htmlspecialchars($_POST["etat"]);
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

	$requete ="SELECT cat_autorisation from t_categorie_cat where cat_id = '" .$idcat. "'";

	$resultat = $mysqli->query($requete);

	$requete2="SELECT inf_etat from t_information_inf where inf_id = '" .$id. "'";

	//Préparation de la requête à partir des chaînes saisies =>
	//concaténation (avec le point) des différents éléments composant la requête

	$sql="UPDATE t_information_inf set inf_etat = 'L'";

	$sql2="UPDATE t_information_inf set inf_etat = 'C'";

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
			$categorie['autorisation'] = $ligne['cat_autorisation'];
			//echo $actualite['pseudo'];
			$result = $mysqli->query($requete2);
			if($result->num_rows == 1)	{
				$li=$result->fetch_assoc();
				$info['etat'] = $li['inf_etat'];
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
					if($categorie['autorisation'] == 'R')	{
						if($info['etat'] == 'L' && $ett == 'L')	{
							echo("Information déjà en ligne");
							echo "<br />";
							exit;
						}
						else if($info['etat'] == 'L' && $ett == 'C')	{
							$result2 = $mysqli->query($sql2);
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
								echo("L'information à bien été caché");
								echo "<br />";
								exit;
							}				
						}
						else if($info['etat'] == 'C' && $ett == 'L')	{
							$result3 = $mysqli->query($sql);
							if ($result3 == false)	{ //Erreur lors de l’exécution de la requête
								// La requête a echoué
								echo "Error: La requête a échoué  \n";
								echo "Query: " . $sql . "\n";
								echo "Errno: " . $mysqli->errno . "\n";
								echo "Error: " . $mysqli->error . "\n";
								exit;
							}
							else
							{
								echo("L'information à bien été mit en ligne");
								echo "<br />";
								exit;
							}							
						}
						else
						{
							echo("L'information est déjà caché");
							echo "<br />";
							exit;

						}

					}
					else
					{
						echo("Vous n'etez pas autorisé à modifié les informations de cette catégorie");
						echo "<br />";
						exit;	
					}
				}
			}

		}
	}
}

//Ferme la connexion avec la base MariaDB
$mysqli->close();
?>