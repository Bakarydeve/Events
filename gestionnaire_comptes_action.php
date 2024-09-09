
<li><a href="gestionnaire_comptes.php"> Comptes </a>
<li><a href="gestionnaire_accueil.php"> Accueil & Mon profil </a>

<?php 
//Ouverture d'une session
session_start();
//Affectation dans des variables du pseudo/mot de passe s'ils existent, affichage d'un message sinon
if ($_POST["pseudo"] && $_POST["validite"])	{
	$psdo=htmlspecialchars(addslashes($_POST["pseudo"]));
	$valdi=htmlspecialchars(addslashes($_POST["validite"]));
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
	// Instructions PHP à ajouter pour l'encodage utf8 du jeu de caractères
	if (!$mysqli->set_charset("utf8")) {
		printf("Pb de chargement du jeu de car. utf8: %s\n", $mysqli->error);
		exit();
	}
	// Requete pour recupere la validite du compte
	$requete = "SELECT pfl_validite from t_profil_pfl where cpt_pseudo = '" .$psdo. "';";
    // Affichage de la requete
	//echo $requete;
	//Exécution de la requête d'ajout d'un compte dans la table des comptes
	$resultat = $mysqli->query($requete);

	//Préparation de la requête à partir des chaînes saisies =>
	//concaténation (avec le point) des différents éléments composant la requête
	$sql="UPDATE t_profil_pfl set pfl_validite = 'A' where cpt_pseudo = '" .$psdo. "';";
	//echo $sql;
	//Exécution de la requête d'ajout d'un compte dans la table des comptes
	
	// Affichage de la requête constituée pour vérification
	//echo($sql);

	//Préparation de la requête à partir des chaînes saisies =>
	//concaténation (avec le point) des différents éléments composant la requête
	$sql2="UPDATE t_profil_pfl set pfl_validite = 'D' where cpt_pseudo = '" .$psdo. "';";
	//echo $sql2;
	//Exécution de la requête d'ajout d'un compte dans la table des comptes
	
	// Affichage de la requête constituée pour vérification
	//echo($sql2);

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
			$validation['validite'] = $ligne['pfl_validite'];
			if($valdi == 'A' && $validation['validite'] == 'A')	{
				//header("Location:gestionnaire_comptes.php");
				echo("Le compte que vous souhaitez activer est déjà actif ");
				exit;
			}
			else if($valdi == 'A' && $validation['validite'] == 'D'){
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
					//header("Location:gestionnaire_comptes.php");
					echo("Le compte à été activer avec succès");
					echo "<br />";
				}
			}
			else if($valdi == 'D' && $validation['validite'] == 'A')	{
            	$result2 = $mysqli->query($sql2);
            	if($result2 == false)	{
        			// La requête a echoué
					echo "Error: La requête a échoué  \n";
					echo "Query: " . $sql . "\n";
					echo "Errno: " . $mysqli->errno . "\n";
					echo "Error: " . $mysqli->error . "\n";
					exit;    		
            	}
            	else
            	{
            		//header("Location:gestionnaire_comptes.php");
					echo("Le compte à été désactiver avec succès");
					echo "<br />";            		
            	}
			}
			else
			{

					//header("Location:gestionnaire_comptes.php");
					echo("Le compte que vous souhaitez désactiver est déjà désactiver ");
					exit;				
			}
		}
	}

 
 ?>