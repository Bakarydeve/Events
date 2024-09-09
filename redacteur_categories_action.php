
<li><a href="redacteur_accueil.php">Accueil & Mon profil</a>
<li><a href="redacteur_categories.php">Gestion des catégories</a>

<?php 
//Ouverture d'une session
session_start();
//Affectation dans des variables du pseudo/mot de passe s'ils existent, affichage d'un message sinon
if ($_POST["texte_inf"] && $_POST["etat_inf"] && $_POST["numero"])	{
	$texte=htmlspecialchars(addslashes($_POST["texte_inf"]));
	$etat=htmlspecialchars($_POST["etat_inf"]);
	$pseudo=$_SESSION['login'];
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

	$requete ="SELECT cat_autorisation from t_categorie_cat where cat_id = '" .$id. "'";


	$resultat = $mysqli->query($requete);

	//Préparation de la requête à partir des chaînes saisies =>
	//concaténation (avec le point) des différents éléments composant la requête

	$sql="INSERT INTO t_information_inf VALUES(NULL,'" .$texte. "',Now(),'" .$etat. "','" .$_SESSION['login']. "','" .$id. "');";

	//$sql="INSERT INTO t_information_inf VALUES(NULL,'" .$texte. "',Now(),'" .$etat. "','" .$pseudo. "','" .$id. "');";	
	// Affichage de la requête constituée pour vérification
	//echo($sql);

	//Exécution de la requête d'ajout d'un compte dans la table des comptes
	//$result = $mysqli->query($sql);

	if ($resultat == false)	{ //Erreur lors de l’exécution de la requête
		// La requête a echoué
		echo "Error: La requête a échoué  \n";
		echo "Query: " . $sql . "\n";
		echo "Errno: " . $mysqli->errno . "\n";
		echo "Error: " . $mysqli->error . "\n";
		exit;
	}
	else                 //Requête réussie
	{
		if($resultat->num_rows == 1)	{
			$ligne=$resultat->fetch_assoc();
			$categorie['autorisation'] = $ligne['cat_autorisation'];
			//echo $actualite['pseudo'];
			if($categorie['autorisation'] == "R")	{
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
					echo("Information ajouté avec succès dans la catégorie $id");
					exit;
				}
			}
			else if($categorie['autorisation'] == "G")
			{
				echo("Vous n'etez pas autorisé à ajouté des informations dans cette catégorie");
				exit;
			}
	}
}
}
else
{
	echo("Veuillez remplir les champs $i et $mdp");
}

