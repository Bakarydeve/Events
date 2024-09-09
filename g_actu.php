
<!-- début du code HTML de la page -->
<form action="g_cat_action.php" method="post">
<fieldset>
 <legend>Veuillez remplir les champs :</legend>
 <p>Votre texte :
 <input type="text" name="texte_inf" placeholder="texte_inf" required="required" />
 </p>
 <p>Etat information :
 <input type="char" name="etat_inf" placeholder="L(en ligne) ou C(caché)" required="required" />
 </p>
  <p>Numero categoie :
 <input type="text" name="numero" placeholder="Numero de la catégorie" required="required" />
 </p>
 <p><input type="submit" value="Valider"></p>
</fieldset>
</form>
<!-- suite du code HTML de la page -->