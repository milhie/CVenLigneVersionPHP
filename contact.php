<?php
  // on inclue le fichier des questions/réponses
  require_once('antispam.php');
 
  // on tire au sort une question
  $nospam = NoSpamQuestion('ask', 0);
?>

<!DOCTYPE html>

<html lang="fr">
  <head>
    <meta charset="utf-8">
    <title>Formulaire de Contact</title>
    <link rel="stylesheet" href="styleform.css" type="text/css" media="all"/>
  </head>
  <body>
    <div id="blocpage">
      <header>
        <h2>Formulaire de Contact</h2>

        <p>Mon profil vous plait? Vous pouvez me contacter via le formulaire ci-dessous:</p>
      </header>

      <main>
    
        <form id="contact" method="post" action="cible.php">
          <fieldset>
            <legend>Vos coordonnées</legend>
            <p><label for="nom">Nom:</label><input type="text" id="nom" name="nom" value="<?php if (isset($_POST['nom'])){echo$_POST['nom'];} ?> "></p>

            <p><label for="email">Email :</label><input type="text" id="email" name="email" value="<?php if (isset($_POST['mail'])){echo$_POST['mail'];} ?> "/></p>

          </fieldset>

          <fieldset>
            <legend>Votre message :</legend>
            <p><label for="objet">Objet :</label><input type="text" id="objet" name="objet" value="<?php if (isset($_POST['objet'])){echo$_POST['objet'];} ?>" >
            </p>

            <p><label for="message">Message :</label><textarea id="message" name="message" placeholder="votre message" cols="30" rows="8"><?php if (isset($_POST['message'])) {echo $_POST['message'];} ?></textarea></p>

            <p><label for="code">Ecrivez en LETTRES le résultat : <?php echo $nospam['question']; ?></label><input type="text" name="code" id="code" /><input type="hidden" name="nospam_question" value="<?php echo $nospam['num']; ?>" /></p>
          </fieldset>
      
          <div id="bouton"><input type="submit" name="envoi" value="Envoyer le formulaire !" /></div>
        </form>
      </main>
    </div>
  </body>
</html>
