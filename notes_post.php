<?php
session_start();
// Connexion à la base de données

$bdd = new PDO('mysql:host=localhost;dbname=espace_membre', 'root', 'guiguivey');
$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Insertion de la note à l'aide d'une requête préparée
$req = $bdd->prepare('INSERT INTO chat (note, date_insertion) VALUES(?, NOW())');
$req->execute(array($_POST['note']));
// Redirection du visiteur vers sa page du profil
header("Location: profil.php?id=".$_SESSION['id']);
?>
