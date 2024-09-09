
<li><a href="gestionnaire_accueil.php"> Accueil & Mon profil </a></li>
<?php 
//Ouverture d'une session
session_start();

if(!isset($_SESSION['login']) && !isset($_SESSION['statut']) || ($_SESSION['statut'] == 'R') )   {
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
<p>Bonjour gestionnaire bienvenue sur votre page url</p>

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

    //Préparation de la requête récupérant tout les url         
    $requete="SELECT * FROM t_url_url";
    $result = $mysqli->query($requete);

    if ($result == false)  { //Erreur lors de l’exécution de la requête
        // La requête a echoué
        echo "Error: La requête a echoué  \n";
        echo "Errno: " . $mysqli->errno . "\n";
        echo "Error: " . $mysqli->error . "\n";
        exit();
    }
    else //La requête s’est bien exécutée (<=> couleur verte dans phpmyadmin)
    {
        echo "<br />";
        //echo($result->num_rows); //Donne le bon nombre de lignes récupérées
        echo "<br />";

        while ($lien = $result->fetch_assoc()) {
            echo ($lien['url_id']  . ' ' . $lien['url_nom']  . ' ' . $lien['url_chaine']);
            echo "<br />";
        }

    }

//Ferme la connexion avec la base MariaDB
$mysqli->close();
?>

<form action="gestionnaire_url_action.php" method="post">
<fieldset>
 <legend>Veuillez remplir les champs si dessous :</legend>
 <p>Nom de la chaine :
 <input type="text" name="nom" placeholder="url_nom" required="required" />
 </p>
  <p>Lien de la chaine :
 <input type="text" name="lien" placeholder="url_chaine" required="required" />
 </p>
 <p><input type="submit" value="Valider"></p>
</fieldset>
</form>

<form action="gestionnaire_urlsup_action.php" method="post">
<fieldset>
 <legend>Veuillez remplir les champs si dessous pour pouvoir supprimer un lien :</legend>
 <p>Numero de la chaine :
 <input type="text" name="numero" placeholder="url_id" required="required" />
 </p>
 <p><input type="submit" value="Valider"></p>
</fieldset>
</form>