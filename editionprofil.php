<?php
session_start();

$bdd = new PDO('mysql:host=127.0.0.1;dbname=espace_membre', 'root', 'guiguivey');

if(isset($_SESSION['id'])) {
   $requser = $bdd->prepare("SELECT * FROM membres WHERE id = ?");
   $requser->execute(array($_SESSION['id']));
   $user = $requser->fetch();
   if(isset($_POST['newpseudo']) AND !empty($_POST['newpseudo']) AND $_POST['newpseudo'] != $user['pseudo']) {
      $newpseudo = htmlspecialchars($_POST['newpseudo']);
      $insertpseudo = $bdd->prepare("UPDATE membres SET pseudo = ? WHERE id = ?");
      $insertpseudo->execute(array($newpseudo, $_SESSION['id']));
      header('Location: profil.php?id='.$_SESSION['id']);
   }
   if(isset($_POST['newmail']) AND !empty($_POST['newmail']) AND $_POST['newmail'] != $user['mail']) {
      $newmail = htmlspecialchars($_POST['newmail']);
      $insertmail = $bdd->prepare("UPDATE membres SET mail = ? WHERE id = ?");
      $insertmail->execute(array($newmail, $_SESSION['id']));
      header('Location: profil.php?id='.$_SESSION['id']);
   }
   if(isset($_POST['newmdp1']) AND !empty($_POST['newmdp1']) AND isset($_POST['newmdp2']) AND !empty($_POST['newmdp2'])) {
      $mdp1 = sha1($_POST['newmdp1']);
      $mdp2 = sha1($_POST['newmdp2']);
      if($mdp1 == $mdp2) {
         $insertmdp = $bdd->prepare("UPDATE membres SET motdepasse = ? WHERE id = ?");
         $insertmdp->execute(array($mdp1, $_SESSION['id']));
         header('Location: profil.php?id='.$_SESSION['id']);
      } else {
         $msg = "Vos deux mdp ne correspondent pas !";
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
         <h2>Edition de mon profil</h2>
         
            <form method="POST" action="" enctype="multipart/form-data" class="form-horizontal">
            <div class="form-group">
               <label class="col-sm-2 control-label">Pseudo :</label>
               <div class="col-sm-10">
               <input type="text" name="newpseudo" class="form-control" placeholder="Pseudo" value="<?php echo $user['pseudo']; ?>" />
               </div>
               </div>
               <div class="form-group">
               <label class="col-sm-2 control-label">Mail :</label>
               <div class="col-sm-10">
               <input type="text" name="newmail" class="form-control" placeholder="Mail" value="<?php echo $user['mail']; ?>" />
               </div>
               </div>
               <div class="form-group">
               <label class="col-sm-2 control-label">Mot de passe :</label>
               <div class="col-sm-10">
               <input type="password" name="newmdp1" class="form-control" placeholder="Mot de passe"/>
               </div>
               </div>
               <div class="form-group">
               <label class="col-sm-2 control-label">Confirmation - mot de passe :</label>
               <div class="col-sm-10">
               <input type="password" name="newmdp2" class="form-control" placeholder="Confirmation du mot de passe" />
               </div>
               </div>
               <input type="submit" class="btn btn-default" value="Mettre à jour mon profil !" />
            </form>
            <?php if(isset($msg)) { echo '
<div class="alert alert-danger">' .$msg. "</div>"; } ?>
         
      </div>
   </body>
   </html>
   <?php   
}
else {
   header("Location: connexion.php");
}
?>