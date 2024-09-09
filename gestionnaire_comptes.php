
<li><a href="gestionnaire_accueil.php"> Accueil & Mon profil </a></li>

<?php 
//Ouverture d'une session
session_start();

if(!isset($_SESSION['login']) && !isset($_SESSION['statut']) || $_SESSION['statut'] == 'R')	{
	//Si la session n'est pas ouverte, redirection vers la page du formulaire
	header("Location:session.php");
	exit();
}
?>

<html>
<head>
<!--entête du fichier HTML-->
</head>
<body>
<!--contenu du fichier HTML-->
<h1>ESPACE GESTIONNAIRE</h1>
<p>Bonjour, <?php echo $_SESSION['login']; ?> bienvenue sur votre page comptes</p>

<?php
/* Code PHP permettant d’afficher le détail du profil de l’utilisateur connecté */

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
     // Instructions PHP à ajouter pour l'encodage utf8 du jeu de caractères
     if (!$mysqli->set_charset("utf8")) {
     	printf("Pb de chargement du jeu de car. utf8: %s\n", $mysqli->error);
     	exit();
     }
     //echo ("Connexion BDD réussie !");

     $sql="SELECT count(*) As Nombre from t_compte_cpt";
     //echo $sql;
     echo "<br />";
	 $result = $mysqli->query($sql);
	/* Exécution de la requête pour vérifier si le compte (=pseudo+mdp) existe !*/
	$result = $mysqli->query($sql);

	if ($result==false) {
    	// La requête a echoué
		echo "Error: La requête a echoué  \n";
    	echo "Errno: " . $mysqli->errno . "\n";
    	echo "Error: " . $mysqli->error . "\n";
     	exit();
	}
	else 
	{
 		if($result->num_rows == 1 )	{
		$ligne=$result->fetch_assoc();
		$_ncpt['compte']= $ligne['Nombre'];
		echo $_ncpt['compte']; echo("Comptes dans la base");
		echo "<br />";
		}
	}



     // Requete 2
     $requete="SELECT * from t_profil_pfl join t_compte_cpt using(cpt_pseudo)";
     //echo $requete;
     echo "<br />";

	/* Exécution de la requête pour vérifier si le compte (=pseudo+mdp) existe !*/
	$resultat = $mysqli->query($requete);

	if ($resultat==false) {
    	// La requête a echoué
		echo "Error: La requête a echoué  \n";
    	echo "Errno: " . $mysqli->errno . "\n";
    	echo "Error: " . $mysqli->error . "\n";
     	exit();
	}
	else //La requête s’est bien exécutée (<=> couleur verte dans phpmyadmin)
	{
		echo "<br />";
		//echo($resultat->num_rows); //Donne le bon nombre de lignes récupérées
		echo "<br />";
		while ($personne = $resultat->fetch_assoc())	{
			echo ($personne['pfl_nom'] . ' ' . $personne['pfl_prenom'] . ' ' . $personne['pfl_validite'] . ' ' . $personne['cpt_pseudo']);
			echo "<br />";
		}

	}
//Ferme la connexion avec la base MariaDB
$mysqli->close();
?>

<form action="gestionnaire_comptes_action.php" method="post">
<fieldset>
 <legend>Veuillez saisir le pseudo du compte à desactiver ou à activer :</legend>
 <p>pseudo du compte :
 <input type="text" name="pseudo" placeholder="cpt_pseudo" required="required" />
 </p>
 <p>Validité du compte :
 <input type="text" name="validite" placeholder="A(activer) ou D(désactiver)" required="required" />
 </p>
 <p><input type="submit" value="Valider"></p>
</fieldset>
</form>


<form action="gestionnaire_comptessup_action.php" method="post">
<fieldset>
 <legend>Veuillez saisir le pseudo du compte à supprimer :</legend>
 <p>pseudo du compte :
 <input type="text" name="pseudo" placeholder="cpt_pseudo" required="required" />
 </p>
 <p><input type="submit" value="Valider"></p>
</fieldset>
</form>
