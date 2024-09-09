
<li><a href="redacteur_accueil.php">Accueil & Mon profil</a>

<?php 
//Ouverture d'une session
session_start();

if(!isset($_SESSION['login']) && !isset($_SESSION['statut']) || $_SESSION['statut'] == 'G')	{
	//Si la session n'est pas ouverte, redirection vers la page du formulaire
    session_destroy();
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
<p>Bonjour, <?php echo $_SESSION['login']; ?> bienvenue sur votre page actualité</p>

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

    //Préparation de la requête récupérant tous actualités      	
    $requete="SELECT * FROM t_news_new;";
    $result2 = $mysqli->query($requete);
    if ($result2 == false)	{ //Erreur lors de l’exécution de la requête
     	// La requête a echoué
     	echo "Error: La requête a echoué  \n";
     	echo "Errno: " . $mysqli->errno . "\n";
     	echo "Error: " . $mysqli->error . "\n";
     	exit();
    }
    else //La requête s’est bien exécutée (<=> couleur verte dans phpmyadmin)
    {
    	echo "<br />";
		//echo($result2->num_rows); //Donne le bon nombre de lignes récupérées
		echo "<br />";

     	while ($actu = $result2->fetch_assoc())	{
     		echo ($actu['new_id']  . ' ' . $actu['new_titre']  . ' ' . $actu['new_texte'] . ' ' . $actu['new_date'] . ' ' . $actu['new_etat']  . ' ' .$actu['cpt_pseudo']);
     		echo "<br />";
     	}

    }

//Ferme la connexion avec la base MariaDB
$mysqli->close();
?>

<form action="redacteur_actuins_action.php" method="post">
<fieldset>
 <legend>Veuillez remplir les champs :</legend>
 <p>Titre de l'actulité :
 <input type="text" name="titre" placeholder="new_titre" required="required" />
 </p>
 <p>Texte de l'actualité :
 <input type="text" name="texte" placeholder="new_texte" required="required" />
 </p>
  <p>Etat de l'actualité :
 <input type="text" name="etat" placeholder="L(en ligne) ou C(caché)" required="required" />
 </p>
 <p><input type="submit" value="Valider"></p>
</fieldset>
</form>


<form action="redacteur_actu_action.php" method="post">
<fieldset>
 <legend>Veuillez saisir le numero de l'actualité à desactiver ou à activer :</legend>
 <p>Numéro de l'actualité :
 <input type="text" name="numero" placeholder="new_id" required="required" />
 </p>
 <p>Etat de l'actualité :
 <input type="text" name="etat" placeholder="L(en ligne) ou C(caché)" required="required" />
 </p>
 <p><input type="submit" value="Valider"></p>
</fieldset>
</form>

<form action="redacteur_actusup_action.php" method="post">
<fieldset>
 <legend>Vous ne pouvez supprimer que les actualités que vous avez mit en ligne :</legend>
 <p>Numéro de l'actualité :
 <input type="text" name="numero" placeholder="new_id" required="required" />
 </p>
 <p><input type="submit" value="Valider"></p>
</fieldset>
</form>