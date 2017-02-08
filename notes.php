<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Mon app</title>
           <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
   <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    </head>
    <style>
    form
    {
        text-align:center;
    }
    </style>
    <body>

    <form action="notes_post.php" method="post">
        <p>
        <label for="note">Note</label> :  <input type="text" name="note" id="note" class="form-control"/>

        <input type="submit" value="Envoyer" class="btn btn-default" />
	</p>
    </form>

<?php
// Connexion à la base de données
try
{
	$bdd = new PDO('mysql:host=localhost;dbname=espace_membre', 'root', 'guiguivey');
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}

// Récupération des 0 dernières notes
$reponse = $bdd->query('SELECT note, DATE_FORMAT(date_insertion, "%d %b %Y %T") AS date_format FROM chat ORDER BY ID DESC LIMIT 0, 30');

// Affichage de chaque message (toutes les données sont protégées par htmlspecialchars)
while ($donnees = $reponse->fetch())
{
	echo '<p><strong>' . $donnees['date_format'] . ' / ' . $donnees['note'] . '</p>';
}

$reponse->closeCursor();

?>
    </body>
</html>
