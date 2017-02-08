<?php
$bdd = new PDO('mysql:host=localhost;dbname=espace_membre', 'root', 'guiguivey');

if(isset($_POST['forminscription'])) {
   $pseudo = $_POST['pseudo'];
   $mail = $_POST['mail'];
   $mail2 = $_POST['mail2'];
   $mdp = sha1($_POST['mdp']);
   $mdp2 = sha1($_POST['mdp2']);
   if(!empty($_POST['pseudo']) AND !empty($_POST['mail']) AND !empty($_POST['mail2']) AND !empty($_POST['mdp']) AND !empty($_POST['mdp2'])) {
      $pseudolength = strlen($pseudo);
      if($pseudolength <= 255) {
         if($mail == $mail2) {
            if(filter_var($mail, FILTER_VALIDATE_EMAIL)) {
               $reqmail = $bdd->prepare('SELECT * FROM membres WHERE mail = ?');
               $reqmail->execute(array($mail));
               $mailexist = $reqmail->rowCount();
               if($mailexist == 0) {
                  if($mdp == $mdp2) {
                     $insertmbr = $bdd->prepare('INSERT INTO membres(pseudo, mail, motdepasse) VALUES(?, ?, ?)');
                     $insertmbr->execute(array($pseudo, $mail, $mdp));
                     $erreur = "Votre compte a bien été créé ! <a href=\"connexion.php\">Me connecter</a>";
                  } else {
                     $erreur = "Vos mots de passes ne correspondent pas !";
                  }
               } else {
                  $erreur = "Adresse mail déjà utilisée !";
               }
            } else {
               $erreur = "Votre adresse mail n'est pas valide !";
            }
         } else {
            $erreur = "Vos adresses mail ne correspondent pas !";
         }
      } else {
         $erreur = "Votre pseudo ne doit pas dépasser 255 caractères !";
      }
   } else {
      $erreur = "Tous les champs doivent être complétés !";
   }
}
?>

<html>
   <head>
      <title>Mon app</title>
      <meta charset="utf-8">
      <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
      <meta name="viewport" content="initial-scale=1, maximum-scale=1">
   </head>
   <body>
      <div align="center">
         <h2>Inscription</h2>
         
         <form method="POST" action="" class="form-horizontal">
         <div class="form-group">                  
                     <label for="pseudo" class="col-sm-2 control-label">Pseudo :</label>
                     <div class="col-sm-10">
                     <input type="text" class="form-control" placeholder="Votre pseudo" id="pseudo" name="pseudo" value="<?php if(isset($pseudo)) { echo $pseudo; } ?>" />
                     </div>
                     </div>
                     <div class="form-group">
                     <label for="mail" class="col-sm-2 control-label">Mail :</label>
                     <div class="col-sm-10">
                     <input type="email" class="form-control"  placeholder="Votre mail" id="mail" name="mail" value="<?php if(isset($mail)) { echo $mail; } ?>" />
                     </div>
                     </div>
                     <div class="form-group">
                     <label for="mail2" class="col-sm-2 control-label">Confirmation du mail :</label>
                     <div class="col-sm-10">
                     <input type="email" class="form-control"  placeholder="Confirmez votre mail" id="mail2" name="mail2" value="<?php if(isset($mail2)) { echo $mail2; } ?>" />
                     </div>
                     </div>
                     <div class="form-group">
                     <label for="mdp" class="col-sm-2 control-label">Mot de passe :</label>
                     <div class="col-sm-10">
                     <input type="password" class="form-control"  placeholder="Votre mot de passe" id="mdp" name="mdp" />
                     </div>
                     </div>
                     <div class="form-group">
                     <label for="mdp2" class="col-sm-2 control-label">Confirmation du mot de passe :</label>
                     <div class="col-sm-10">
                     <input type="password" class="form-control"  placeholder="Confirmez votre mdp" id="mdp2" name="mdp2" />
                     </div>
                     </div>
                     </div>
                     <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                     <input type="submit" class="btn btn-default" name="forminscription" value="Je m'inscris" />
                     </div>
                     </div>

            </div>
         </form>
         <?php
         if(isset($erreur)) {
            echo '
<div class="alert alert-danger">'.$erreur."</div>";
         }
         ?>
      </div>
   </body>
</html>