<?php

    
/* ATTENTION : si le formulaire a une méthode method="get", remplacez $_POST par $_GET */
// on teste si le formulaire a été soumis
    

if (isset($_POST['envoi']))
{
	require_once('antispam.php'); // pour définir les images, les questions et les réponses
 
	// récuperation des variables du formulaire
	/*
	
	*******************************************************************************************
	CONFIGURATION
	********************************************************************************************
	*/
	
	// destinataire est votre adresse mail. Pour envoyer à plusieurs à la fois, séparez-les par une virgule
	$destinataire = 'cvmilhie@gmail.com';
     
	// copie ? (envoie une copie au visiteur)
	$copie = 'oui'; // 'oui' ou 'non'
     
	// Messages de confirmation du mail
	$message_envoye = "Votre message nous est bien parvenu ! Une copie de votre message vous a été envoyée.<br /> Retourner au <a href='https://milhie.github.io/CVenLigne/'> CV </a>";
	$message_non_envoye = "L'envoi du mail a échoué, veuillez réessayer SVP.";

     
	// Messages d'erreur du formulaire
	$message_erreur_formulaire = "Vous devez d'abord <a href=\"contact.php\">envoyer le formulaire</a>.";
	$message_formulaire_invalide = "Vérifiez que tous les champs soient bien remplis et que l'email soit sans erreur.";
     

	/*
		********************************************************************************************
    		FIN DE LA CONFIGURATION
    	********************************************************************************************
	*/


 
	// n'oublions pas les 2 variables du captcha :
	$code = (isset($_POST['code'])) ? strtolower($_POST['code']) : ''; // contient la réponse du visiteur
	$nospam_question = (isset($_POST['nospam_question'])) ? $_POST['nospam_question'] : ''; // contient un nombre : le numéro de la vraie réponse
 
	// On demande la vraie réponse
	$verif_nospam = NoSpamQuestion('ans', $nospam_question);
 
	// on compare la 'vraie' réponse et celle du visiteur
	if ($code != strtolower($verif_nospam['answer']))
	{
		// le formulaire s'arrête ici
		echo '<p>Vous n\'avez pas répondu correctement à la question antispam .... <a href="contact.php> Retour au formulaire</a></p>';
	}
	else
	{
		// traitement du formulaire comme souhaité ...
     
    		
    	/*
   	 	* cette fonction sert à nettoyer et enregistrer un texte
   		*/
		function Rec($text)
		{
   			$text = htmlspecialchars(trim($text), ENT_QUOTES);
   			if (1 === get_magic_quotes_gpc())
   			{
   				$text = stripslashes($text);
   			}
   			$text = nl2br($text);
   			return $text;
   		};
     
   		/*
   		* Cette fonction sert à vérifier la syntaxe d'un email
   		*/
   		function IsEmail($email)
   		{
   			$value = preg_match('/^(?:[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+\.)*[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+@(?:(?:(?:[a-zA-Z0-9_](?:[a-zA-Z0-9_\-](?!\.)){0,61}[a-zA-Z0-9_-]?\.)+[a-zA-Z0-9_](?:[a-zA-Z0-9_\-](?!$)){0,61}[a-zA-Z0-9_]?)|(?:\[(?:(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\.){3}(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\]))$/', $email);
   			return (($value === 0) || ($value === false)) ? false : true;
   		}
     
   		// formulaire envoyé, on récupère tous les champs.
   		$nom     = (isset($_POST['nom']))     ? Rec($_POST['nom'])     : '';
    	$email   = (isset($_POST['email']))   ? Rec($_POST['email'])   : '';
		$objet   = (isset($_POST['objet']))   ? Rec($_POST['objet'])   : '';
		$message = (isset($_POST['message'])) ? Rec($_POST['message']) : '';
 
		// On va vérifier les variables et l'email ...
		$email = (IsEmail($email)) ? $email : ''; // soit l'email est vide si erroné, soit il vaut l'email entré
   
		if (($nom != '') && ($email != '') && ($objet != '') && ($message != ''))
		{
			// les 4 variables sont remplies, on génère puis envoie le mail
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'From:'.$nom.' <'.$email.'>' . "\r\n" .
  				'Reply-To:'.$email. "\r\n" .
   				'Content-Type: text/plain; charset="utf-8"; DelSp="Yes"; format=flowed '."\r\n" .
   				'Content-Disposition: inline'. "\r\n" .
   				'Content-Transfer-Encoding: 7bit'." \r\n" .
   				'X-Mailer:PHP/'.phpversion();
     
			// envoyer une copie au visiteur ?
			if ($copie == 'oui')
			{
				$cible = $destinataire.';'.$email;
			}
			else
			{
				$cible = $destinataire;
			};
     
			// Remplacement de certains caractères spéciaux
			$caracteres_speciaux     = array('&#039;', '&#8217;', '&quot;', '<br>', '<br />', '&lt;', '&gt;', '&amp;', '…',   '&rsquo;', '&lsquo;');
			$caracteres_remplacement = array("'",      "'",        '"',      '',    '',       '<',    '>',    '&',     '...', '>>',      '<<'     );
    
	    	$objet = html_entity_decode($objet);
   			$objet = str_replace($caracteres_speciaux, $caracteres_remplacement, $objet);
     
   			$message = html_entity_decode($message);
   			$message = str_replace($caracteres_speciaux, $caracteres_remplacement, $message);
     
   				// Envoi du mail
			$num_emails = 0;
			$tmp = explode(';', $cible);
			foreach($tmp as $email_destinataire)
			{
				if (mail($email_destinataire, $objet, $message, $headers))
					$num_emails++;
			}
     
			if ((($copie == 'oui') && ($num_emails == 2)) || (($copie == 'non') && ($num_emails == 1)))
			{
				echo '<p>'.$message_envoye.'</p>';
			}
			else
			{
				echo '<p>'.$message_non_envoye.'</p>';
			};
		}
		else
		{
			// une des 3 variables (ou plus) est vide ...
			echo '<p>'.$message_formulaire_invalide.' <a href="contact.php">Retour au formulaire</a></p>'."\n";
		};
   		
}; // fin du if (isset($_POST['submit']))
?>