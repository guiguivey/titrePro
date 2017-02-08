<?php
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=espace_membre', 'root', 'guiguivey');

// Insertion du message à l'aide d'une requête préparée
$req = $bdd->prepare('INSERT INTO chat (note, date_insertion) VALUES(?, ?)');
$req->execute(array($_POST['note'], $_POST['date_insertion']));

// Redirection du visiteur vers la page du minichat
header("Location: profil.php?id=".$_SESSION['id']);
?>