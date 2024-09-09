<?php 
//Ouverture d'une session
session_start();
//Affectation dans des variables du pseudo/mot de passe s'ils existent, affichage d'un message sinon
if ($_POST["pseudo"] && $_POST["mdp"])	{
	$id=htmlspecialchars(addslashes($_POST["pseudo"]));
	$motdepasse=htmlspecialchars(addslashes($_POST["mdp"]));
}
else
{
	echo("Veuillez remplir les champs $i et $mdp");
}

// Connexion à la base MariaDB
$mysqli = new mysqli('localhost','zberteba0','t54kv87z','zfl2-zberteba0');
if ($mysqli->connect_errno)	{
	// Affichage d'un message d'erreur
	echo "Error: Problème de connexion à la BDD \n";
	echo "Errno: " . $mysqli->connect_errno . "\n";
	echo "Error: " . $mysqli->connect_error . "\n";
	// Arrêt du chargement de la page
	exit();
}

echo ("Connexion BDD réussie !");
echo "<br />";
// Instructions PHP à ajouter pour l'encodage utf8 du jeu de caractères
if (!$mysqli->set_charset("utf8")) {
	printf("Pb de chargement du jeu de car. utf8: %s\n", $mysqli->error);
	exit();
}
//Préparation de la requête à partir des chaînes saisies =>
//concaténation (avec le point) des différents éléments composant la requête

// Requête SQL de recherche du compte utilisateur (+ validité + statut du profil) à partir du pseudo / mot de passe saisis
 


// Requête avec une jointure pour rechercher si un compte utilisateur valide (‘A’) existe dans la table des données des profils et récupérer aussi son statut à partir du pseudo / mot de passe saisis

$requete2="SELECT pfl_statut, cpt_pseudo from t_compte_cpt join t_profil_pfl using(cpt_pseudo) where cpt_pseudo='" . $id . "' And cpt_mot_de_passe=MD5('" . $motdepasse . "') and pfl_validite = 'A';";
echo("$requete2");
echo "<br />";

/* Exécution de la requête pour vérifier si le compte (=pseudo+mdp) existe !*/
$resultat = $mysqli->query($requete2);


if ($resultat==false) {
 // La requête a echoué
	echo "Error: La requête a echoué  \n";
    echo "Errno: " . $mysqli->errno . "\n";
    echo "Error: " . $mysqli->error . "\n";
     		
 exit();
}

else 
{
 /* A NOTER : si on a complété la requête 1) proposée, on peut aussi
 récupérer et tester la validité du profil, en faisant, par exemple : */
    


 	if($resultat->num_rows == 1 )	{

		$ligne=$resultat->fetch_assoc();
 		$_SESSION['login']=$id;
        $_SESSION['statut']= $ligne['pfl_statut'];
        echo $_SESSION['statut'];

 		echo("Le compte existe dans la base et est bien actif");
 		echo "<br />";
		if($_SESSION['statut']=='G')	{
			header("Location:gestionnaire_accueil.php");
		}
		else
		{
			header("Location:redacteur_accueil.php");

		}
 	}
 	else
 	{
 		// aucune ligne retournée
 		// => le compte n'existe pas ou n'est pas valide
 		echo "pseudo/mot de passe incorrect(s) ou profil inconnu !";
		echo "<br /><a href=\"./session.php\">Cliquez ici pour reafficher le formulaire</a>";
 
 	}
 	
}
$mysqli->close();


?>


