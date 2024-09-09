
<li><a href="redacteur_accueil.php">Accueil & Mon profil</a>
    
<?php 
//Ouverture d'une session
session_start();

if(!isset($_SESSION['login']) && !isset($_SESSION['statut']) || $_SESSION['statut'] == 'G')   {
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
<p>Bonjour, <?php echo $_SESSION['login']; ?> bienvenue sur votre page catégories</p>

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

            
    $requete1="SELECT cat_id FROM t_categorie_cat;";
    //Affichage de la requête préparée
    //echo ($requete1);
    //echo ("<br />");
    $result1 = $mysqli->query($requete1);
    $nb_ligne = $result1->num_rows;
    if ($result1 == false)  { //Erreur lors de l’exécution de la requête{   
        // La requête a echoué
        echo "Error: La requête a echoué  \n";
        echo "Errno: " . $mysqli->errno . "\n";
        echo "Error: " . $mysqli->error . "\n";
        exit();
    }
    else //La requête s’est bien exécutée (<=> couleur verte dans phpmyadmin)
    {
        for ($i=0;$i<$result1->num_rows;$i++)   {
            $cat = $result1->fetch_assoc();
            $id[$i]=$cat['cat_id'];
        }
        //1ère catégorie
        $requete2="SELECT inf_id,inf_texte,inf_date,inf_etat,cpt_pseudo FROM t_information_inf where cat_id = $id[0];";
        //Affichage de la requête préparée
        //echo ($requete2);
        //echo ("<br />");
        $result2 = $mysqli->query($requete2);
        //2ème catégorie
        $requete3="SELECT inf_id,inf_texte,inf_date,inf_etat,cpt_pseudo FROM t_information_inf where cat_id = $id[1];";
        //Affichage de la requête préparée
        //echo ($requete2);
        //echo ("<br />");
        $result3 = $mysqli->query($requete3);
        //3ème catégorie
        $requete4="SELECT inf_id,inf_texte,inf_date,inf_etat,cpt_pseudo FROM t_information_inf where cat_id = $id[2];";
        //Affichage de la requête préparée
        //echo ($requete2);
        //echo ("<br />");
        $result4 = $mysqli->query($requete4);
        //4ème catégories
        $requete5="SELECT inf_id,inf_texte,inf_date,inf_etat,cpt_pseudo FROM t_information_inf where cat_id = $id[3];";
        //Affichage de la requête préparée
        //echo ($requete2);
        //echo ("<br />");
        $result5 = $mysqli->query($requete5);
        if ($result2 == false)  { //Erreur lors de l’exécution de la requête
            // La requête a echoué
            echo "Error: La requête a echoué  \n";
            echo "Errno: " . $mysqli->errno . "\n";
            echo "Error: " . $mysqli->error . "\n";
            exit();
        }
        else //La requête s’est bien exécutée (<=> couleur verte dans phpmyadmin)
        {
            if($result2->num_rows == 0) {
                echo("Aucune information dans cette catégorie ");
            }
            else
            {
                echo("1ère catégories"); //Donne le bon nombre de lignes récupérées
                echo "<br />";
                while ($info = $result2->fetch_assoc()) {
                    echo ($info['inf_id']  . ' ' .  $info['inf_texte'] . ' ' . $info['inf_etat']  . ' ' . $info['inf_date']);
                    echo "<br />";
                }
                if ($result3 == false)  { //Erreur lors de l’exécution de la requête
                    // La requête a echoué
                    echo "Error: La requête a echoué  \n";
                    echo "Errno: " . $mysqli->errno . "\n";
                    echo "Error: " . $mysqli->error . "\n";
                    exit();
                }
                else //La requête s’est bien exécutée (<=> couleur verte dans phpmyadmin)
                {
                    if($result3->num_rows == 0)  {
                    echo("Aucune information dans cette catégorie ");
                    }
                    else
                    {
                        echo("2ème catégories"); //Donne le bon nombre de lignes récupérées
                        echo "<br />";
                        while ($info = $result3->fetch_assoc())  {
                            echo ($info['inf_id']  . ' ' .   $info['inf_texte'] . ' ' . $info['inf_etat']  . ' ' . $info['inf_date']);
                            echo "<br />";
                        }
                        if ($result4 == false)  { //Erreur lors de l’exécution de la requête
                            // La requête a echoué
                            echo "Error: La requête a echoué  \n";
                            echo "Errno: " . $mysqli->errno . "\n";
                            echo "Error: " . $mysqli->error . "\n";
                            exit();
                        }
                        // début des problèmes
                        else //La requête s’est bien exécutée (<=> couleur verte dans phpmyadmin)
                        {
                            if($result4->num_rows == 0)  {
                                echo("Aucune information dans cette catégorie ");
                            }
                            else
                            {
                                echo("3ème catégories");
                                echo "<br />";
                                // Oula ca passe mdr
                                while ($info = $result4->fetch_assoc()) {
                                    echo($info['inf_id']  . ' ' .   $info['inf_texte'] . ' ' . $info['inf_etat'] . ' ' . $info['inf_date']);
                                    echo "<br />";
                                }
                                // yeah maintenant la dernière
                                // 4ème catégories
                                if ($result5 == false)  { //Erreur lors de l’exécution de la requête
                                    // La requête a echoué
                                    echo "Error: La requête a echoué  \n";
                                    echo "Errno: " . $mysqli->errno . "\n";
                                    echo "Error: " . $mysqli->error . "\n";
                                    exit();
                                }
                                else //La requête s’est bien exécutée (<=> couleur verte dans phpmyadmin)
                                {
                                    if($result4->num_rows == 0)  {
                                        echo("Aucune information dans cette catégorie ");
                                    }
                                    else
                                    {
                                        echo("4ème catégories");
                                        echo "<br />";
                                        // Ouai
                                        while ($info = $result5->fetch_assoc()) {
                                            echo($info['inf_id']  . ' ' .   $info['inf_texte'] . ' ' . $info['inf_etat'] . ' ' . $info['inf_date']);
                                            echo "<br />";
                                        }

                                    }
                                }

                            }
                        }

                    }

                }
            }

        }
    }

//Ferme la connexion avec la base MariaDB
$mysqli->close();
?>

<form action="redacteur_categories_action.php" method="post">
<fieldset>
 <legend>Veuillez remplir les champs :</legend>
 <p>Votre texte :
 <input type="text" name="texte_inf" placeholder="inf_texte" required="required" />
 </p>
 <p>Etat information :
 <input type="text" name="etat_inf" placeholder="inf_etat" required="required" />
 </p>
 <p>Numero catégorie :
 <input type="text" name="numero" placeholder="Numero de la catégorie" required="required" />
 </p>
 <p><input type="submit" value="Valider"></p>
</fieldset>
</form>

<form action="redacteur_categories_modif.php" method="post">
<fieldset>
 <legend>Veuillez saisir l'identifiant et la catégorie de l'information à activé ou désactive :</legend>
 <p>Identifiant de l'information:
 <input type="text" name="numero" placeholder="inf_id" required="required" />
 </p>
 <p>Etat information :
 <input type="text" name="etat" placeholder="inf_etat" required="required" />
 </p>
 <p>Identifiant catégorie:
 <input type="text" name="catnum" placeholder="cat_id" required="required" />
 </p>
 <p><input type="submit" value="Valider"></p>
</fieldset>
</form>

<form action="redacteur_supcatinf_action.php" method="post">
<fieldset>
 <legend>Veuillez saisir l'identifiant et la catégorie de l'information à supprime :</legend>
 <p>Identifiant :
 <input type="text" name="numero" placeholder="inf_id" required="required" />
 </p>
  <p>Identifiant :
 <input type="text" name="catnum" placeholder="cat_id" required="required" />
 </p>
 <p><input type="submit" value="Valider"></p>
</fieldset>
</form>