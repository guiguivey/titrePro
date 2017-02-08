<?php
session_start();

$bdd = new PDO('mysql:host=127.0.0.1;dbname=espace_membre', 'root', 'guiguivey');

if(isset($_POST['formconnexion'])) {
   $mailconnect = htmlspecialchars($_POST['mailconnect']);
   $mdpconnect = sha1($_POST['mdpconnect']);
   if(!empty($mailconnect) AND !empty($mdpconnect)) {
      $requser = $bdd->prepare("SELECT * FROM membres WHERE mail = ? AND motdepasse = ?");
      $requser->execute(array($mailconnect, $mdpconnect));
      $userexist = $requser->rowCount();
      if($userexist == 1) {
         $userinfo = $requser->fetch();
         $_SESSION['id'] = $userinfo['id'];
         $_SESSION['pseudo'] = $userinfo['pseudo'];
         $_SESSION['mail'] = $userinfo['mail'];
         header("Location: profil.php?id=".$_SESSION['id']);
      } else {
         $erreur = "Mauvais mail ou mot de passe !";
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

   <h2>Connexion</h2>

   <form method="POST" action="" class="form-horizontal">
      <div class="form-group">
         <label for="mail" class="col-sm-2 control-label">Mail :</label>
         <div class="col-sm-10">
            <input type="email" name="mailconnect" placeholder="Mail" class="form-control" />
         </div>
      </div>
      <div class="form-group">
         <label for="mail" class="col-sm-2 control-label">Mot de passe :</label>
         <div class="col-sm-10">
            <input type="password" name="mdpconnect" placeholder="Mot de passe" class="form-control" />
         </div>
      </div>
        <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <input type="submit" name="formconnexion" value="Se connecter !" class="btn btn-default"/>
      </div>
      </div>
   </form>
   <?php
   if(isset($erreur)) {
      echo '<font color="red">'.$erreur."</font>";
   }
   ?>
</div>
</body>
</html>