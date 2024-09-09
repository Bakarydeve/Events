<?php 
//Ouverture d'une session
session_start();

if(!isset($_SESSION['login']) && !isset($_SESSION['statut']) || $_SESSION['statut'] == 'R')	{
	//Si la session n'est pas ouverte, redirection vers la page du formulaire
    session_destroy();
	header("Location:session.php");
	exit();
}
//echo $_SESSION['login'];
?>

<html>
<head>

<!--entête du fichier HTML-->
</head>
<body>
<!--contenu du fichier HTML-->

<li><a href="gestionnaire_accueil.php"> Accueil & Mon profil </a></li>
<li><a href="gestionnaire_comptes.php"> Comptes </a></li>
<li><a href="gestionnaire_actualite.php">  Actualités </a></li>
<li><a href="gestionnaire_catinfo.php"> Catégories / informations </a></li>
<li><a href="gestionnaire_url.php"> URL </a></li>
<li><a href="ges_out.php">Déconnexion</a></li>
<h1>ESPACE GESTIONNAIRE</h1>
<p>Bonjour gestionnaire bienvenue sur votre page d'accueil</p>

<?php
//header("refresh:5;url=gestionnaire_comptes.php");
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
	$requete="SELECT * from t_profil_pfl where cpt_pseudo='" . $_SESSION['login'] . "'";
	//echo("$requete");
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
		echo ($personne['pfl_nom'] . ' ' . $personne['pfl_prenom'] . ' ' . $personne['pfl_email'] . ' ' . $personne['pfl_statut'] . ' ' . $personne['pfl_date'] . ' ' . $personne['cpt_pseudo']);
		echo "<br />";
	}

}
//Ferme la connexion avec la base MariaDB
$mysqli->close();
?>