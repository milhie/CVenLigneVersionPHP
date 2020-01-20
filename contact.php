
<p>Mon profil vous plait? Vous pouvez me contacter via le fomulaire ci dessous:</p>

<form method="post" action="cible.php">
 
   	<fieldset>
       <legend>Vos coordonnées</legend> <!-- Titre du fieldset --> 

       <label for="nom">Quel est votre nom ?</label>
       <input type="text" name="nom" id="nom" required />

       <label for="email">Votre e-mail:</label>
       <input type="email" name="email" id="email" required />

       <label for="tph">Numéro de téléphone:</label>
       <input type="tel" name="tph" id="tph" />

   	</fieldset>
   	<fieldset>
   		<label for="message">Votre message:</label>
   		<textarea name="message" id="message" rows="10" cols="50" required></textarea>
   	</fieldset>
 
   
</form>