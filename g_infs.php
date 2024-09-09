<li><a href="gestionnaire_accueil.php"> Accueil gestionnaire </a>
<li><a href="gest_cat.php"> Affichage des catégories </a>
<!-- début du code HTML de la page -->
<form action="g_infs_action.php" method="post">
<fieldset>
 <legend>Veuillez saisir l'identifiant de l'information à supprimé :</legend>
 <p>Identifiant :
 <input type="text" name="numero" placeholder="inf_id" required="required" />
 </p>
 <p><input type="submit" value="Valider"></p>
</fieldset>
</form>
<!-- suite du code HTML de la page -->