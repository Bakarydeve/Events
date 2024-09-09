<?php 
//Ouverture d'une session
session_start();
if(isset($_SESSION['login']))	{
	//Si la session n'est pas ouverte, redirection vers la page du formulaire
	unset($_SESSION['login']);
	header("Location:session.php");

}
else
{
	echo("Erreur un souci");
}
?>