<?php 
//Ouverture d'une session
session_start();

if(!isset($_SESSION['login']) && !isset($_SESSION['statut']))   {
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
<p>Bonjour, <?php echo $_SESSION['login']; ?> bienvenue sur votre page visuels</p>

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

     $requete="SELECT vir_id,vir_description,vir_nom_fichier,vir_visibilite from t_virtuel_vir";
     //echo $requete
     $resultat = $mysqli->query($requete);

    if ($resultat == false)  { //Erreur lors de l’exécution de la requête{   
        // La requête a echoué
        echo "Error: La requête a echoué  \n";
        echo "Errno: " . $mysqli->errno . "\n";
        echo "Error: " . $mysqli->error . "\n";
        exit();
    }
    else
    {
	    echo "<br />";
	    while ($visuel = $resultat->fetch_assoc())	{
	       echo ($visuel['vir_id'] . ' ' . $visuel['vir_description'] . ' ' . $visuel['vir_nom_fichier'] . ' ' . $visuel['vir_visibilite']);
		   echo "<br />";
	    }
    }

//Ferme la connexion avec la base MariaDB
$mysqli->close();
?>

<form action="redacteur_visuels_action.php" method="post">
<fieldset>
 <legend>Veuillez remplir les champs :</legend>
 <p>Description du visuel :
 <input type="text" name="description" placeholder="vir_description" required="required" />
 </p>
 <p>Nom du visuel :
 <input type="text" name="nom" placeholder="vir_nom" required="required" />
 </p>
 <p>Etat du visuel :
 <input type="text" name="etat" placeholder="vir_visibilite" required="required" />
 </p>
 <p><input type="submit" value="Valider"></p>
</fieldset>
</form>

<form action="redacteur_vismodis_action.php" method="post">
<fieldset>
 <legend>Vous ne pouvez modifier que l'état des visuels que vous avez ajouté :</legend>
 <p>Numero du visuel :
 <input type="text" name="numero" placeholder="vir_id" required="required" />
 </p>
 <p>Etat du visuel :
 <input type="text" name="etat" placeholder="vir_etat" required="required" />
 </p>
 <p><input type="submit" value="Valider"></p>
</fieldset>
</form>

<form action="redacteur_vissup_action.php" method="post">
<fieldset>
 <legend>Vous ne pouvez modifier que l'état des visuels que vous avez ajouté :</legend>
 <p>Numero du visuel :
 <input type="text" name="numero" placeholder="vir_id" required="required" />
 </p>
 <p><input type="submit" value="Valider"></p>
</fieldset>
</form>