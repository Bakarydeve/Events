
<li><a href="gestionnaire_comptes.php"> Comptes </a>
<li><a href="gestionnaire_accueil.php"> Accueil & Mon profil </a>

<?php 
//Ouverture d'une session
session_start();
//Affectation dans des variables du pseudo/mot de passe s'ils existent, affichage d'un message sinon
if ($_POST["pseudo"])	{
	$psdo=htmlspecialchars(addslashes($_POST["pseudo"]));
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
	// requete de suppression du profil
	$requete="DELETE from t_profil_pfl where cpt_pseudo = '" .$psdo. "';";
	// affichage de la requete
	//echo $requete;
	//Exécution de la requête de suppression du profil  dans la table des profils
	$resultat = $mysqli->query($requete);

	// requete de suppression du compte
	$sql="DELETE from t_compte_cpt where cpt_pseudo = '" .$psdo. "';";
	// affichage de la requete
	//echo $sql;

    if ($resultat == false)  { //Erreur lors de l’exécution de la requête
        // La requête a echoué
        echo "Error: La requête a echoué  \n";
        echo "Errno: " . $mysqli->errno . "\n";
        echo "Error: " . $mysqli->error . "\n";
        exit();
    }
    else
    {
    	echo("profil supprimé avec succès");
    	echo "<br />";
    	$result = $mysqli->query($sql);
    	if ($result == false)  { //Erreur lors de l’exécution de la requête
        	// La requête a echoué
        	echo "Error: La requête a echoué  \n";
        	echo "Errno: " . $mysqli->errno . "\n";
        	echo "Error: " . $mysqli->error . "\n";
        	exit();
    	}
    	else
    	{
    		echo("Compte supprimé avec succès");
    		exit;
    	}

    }
