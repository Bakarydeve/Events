
<li><a href="redacteur_accueil.php">Accueil & Mon profil</a>
<li><a href="redacteur_visuels.php">Gestion des visuels</a>

<?php 
//Ouverture d'une session
session_start();
//Affectation dans des variables du pseudo/mot de passe s'ils existent, affichage d'un message sinon
if ($_POST["numero"] &&  $_POST["etat"])	{
	$id=htmlspecialchars($_POST["numero"]);
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

	$requete="SELECT cpt_pseudo from t_virtuel_vir where vir_id = '" .$id. "'";

	$resultat = $mysqli->query($requete);

	$requete2="SELECT vir_visibilite from t_virtuel_vir where vir_id = '" .$id. "'";

	$sql="UPDATE t_virtuel_vir set vir_visibilite ='L'";

	$sql2="UPDATE t_virtuel_vir set vir_visibilite ='C'";

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
				$li=$result->fetch_assoc();
				$visuel['visibilite'] = $li['vir_visibilite'];
				//echo $actualite['pseudo'];
				if($visuel['psdo'] == $_SESSION['login'])	{
					if($ett == 'L' && $visuel['visibilite'] == 'L')	{
						echo("Visuel déjà en ligne");
						echo "<br />";
					}
					else if($ett == 'L' && $visuel['visibilite'] == 'C')	{
						$result2 = $mysqli->query($sql);
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
							echo("Visuel mit en ligne avec succès");
							echo "<br />";
						}					
					}
					else if($ett == 'C' && $visuel['visibilite'] == 'L')	{
						$result3 = $mysqli->query($sql2);
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
							echo("Visuel caché avec succès");
							echo "<br />";
						}	
					}
					else
					{
						echo("Visuel déjà caché");
						echo "<br />";
					}
				}
				else
				{
					echo("Vous n'etez pas autorisé à modifié ce visuel");
					exit;
				}

			}
		}

	}
	



