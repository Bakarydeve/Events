
<li><a href="redacteur_accueil.php">Accueil & Mon profil </a>
<li><a href="redacteur_actualite.php">Gestion des actualités</a>
<li><a href="redacteur_categories.php">Gestion des catégories </a>
<li><a href="redacteur_visuels.php">Gestion des visuels</a>
<li><a href="redacteur_url.php">Gestion des URL </a>
<li><a href="redacteur_informations.php"> Gestion des informations</a>
<li><a href="r_out.php">Déconnexion</a>

<?php 
//Ouverture d'une session
session_start();

if(!isset($_SESSION['login']) && !isset($_SESSION['statut']))	{
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
<h1>ESPACE REDACTEUR</h1>
<p>Bonjour, <?php echo $_SESSION['login']; ?> bienvenue sur votre page d'accueil</p>
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
	       echo ($personne['pfl_nom'] . ' ' . $personne['pfl_prenom']);
		   echo "<br />";
	    }

    }
//Ferme la connexion avec la base MariaDB
$mysqli->close();
?>