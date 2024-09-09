Bonjour, <?php echo htmlspecialchars($_POST['pseudo']); ?>.
MDP choisi : <?php echo htmlspecialchars($_POST['mdp']); ?> !

<?php
if($_POST['pseudo'] && $_POST['mdp'] &&  $_POST['v_mdp'])
{
	$id=htmlspecialchars(addslashes($_POST["pseudo"]));
    $mdp=htmlspecialchars(addslashes($_POST["mdp"]));
    $verif=htmlspecialchars(addslashes($_POST["v_mdp"]));
}
else
{
	echo("Une ou plusieurs informations manquante pour la création du compte veuillez les saisir !");
	$probleme ='1';
		if($probleme==1)
		{
			echo("<form action=\"action.php\" method=\"post\">");
			$id=htmlspecialchars(addslashes($_POST["pseudo"]));
			$mdp=htmlspecialchars(addslashes($_POST["mdp"]));
			$verif=htmlspecialchars(addslashes($_POST["v_mdp"]));
		}
	
}
if(strcmp($mdp, $verif)==0)
{
	echo("Mots de passe bien saisie !");

	if($_POST['nom'] && $_POST['prenom'] &&  $_POST['email'] && $_POST['pseudo'])
	{
		$name=htmlspecialchars((addslashes($_POST['nom'])));
    	$seconde_name=htmlspecialchars((addslashes($_POST['prenom'])));
    	$mail=htmlspecialchars((addslashes($_POST['email'])));
		$stat='R';
    	$validation='D';
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

			echo ("Connexion BDD réussie !");

			// Instructions PHP à ajouter pour l'encodage utf8 du jeu de caractères
			if (!$mysqli->set_charset("utf8")) {
				printf("Pb de chargement du jeu de car. utf8: %s\n", $mysqli->error);
				exit();
			}

			//Préparation de la requête à partir des chaînes saisies =>
			//concaténation (avec le point) des différents éléments composant la requête

			$sql="INSERT INTO t_compte_cpt VALUES('" .$id. "',MD5('" .$mdp. "'));";

			// Affichage de la requête constituée pour vérification
			echo($sql);

			//Exécution de la requête d'ajout d'un compte dans la table des comptes
			$result3 = $mysqli->query($sql);

			if ($result3 == false) //Erreur lors de l’exécution de la requête
			{
				// La requête a echoué
				echo "Error: La requête a échoué  \n";
				echo "Query: " . $sql . "\n";
				echo "Errno: " . $mysqli->errno . "\n";
				echo "Error: " . $mysqli->error . "\n";
				exit;
			}
			else                 //Requête réussie
			{
				echo("Compte crée avec succès");
				echo "<br />";
				$sql1="INSERT INTO t_profil_pfl VALUES('" .$name. "','" .$seconde_name. "','" .$mail. "','" .$stat. "','" .$validation. "',Now(),'" .$id. "');";
				echo "<br />";
				echo($sql1);
				$result4 = $mysqli->query($sql1);
				if ($result4 == false) //Erreur lors de l’exécution de la requête
				{
					// La requête a echoué
					echo("Compte supprimé avec succès");
					echo "<br />";
					echo "Error: La requête a échoué  \n";
					echo "Query: " . $sql . "\n";
					echo "Errno: " . $mysqli->errno . "\n";
					echo "Error: " . $mysqli->error . "\n";
					echo "<br />";
					$sql2="DELETE from t_compte_cpt where cpt_pseudo ='".$id."';";
					echo($sql2);
					$result5 =  $mysqli->query($sql2);
					if($result5 == true)
					{
						echo("Compte supprimé avec succès");
						exit;
					}
					else
					{
						echo("Le compte n'a pas été supprimé veuillez verifiez votre requête");
						exit;
					}
					
				}
				else
				{
					echo "<br />";
					echo "Inscription réussie!" . "\n";			
				}
					
			}





			//Ferme la connexion avec la base MariaDB
			$mysqli->close();
    		
	}
	else
	{
		echo("Une ou plusieurs informations manquante pour la création du profil veuillez les saisir !");
		echo "<br />";
		echo("<a href ='inscription.php'>inscription</a>");
	}
}
else
{
	echo("Veuillez verifiez et resaisire votre mot de passe !");
	echo "<br />";
	echo("<a href ='inscription.php'>inscription</a>");
}



?>