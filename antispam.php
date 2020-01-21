<?php 
/*
* NoSpamQuestion affiche une question pour la validation d'un formulaire ...
* $mode, mode question ou réponse par défaut tirage au sort de question {string}
* $answer, lors de la demande d'une réponse à la question numero tant ... {int}
*
* @returns array
*
* Ajouter une question :
* copier/coller ces lignes et remplir le contenu entre guillemets doubles :
*
* $array_pictures[$j]['num'] = $j; // ne pas changer cette ligne
* $array_pictures[$j]['question'] = "mettre ici la question (correspondant à l'image si vous utilisez une image)";
* $array_pictures[$j]['answer'] = "mettre ici la réponse à l'énigme";
* $j++; // ne pas oublier cette ligne dans la copie :-)
*
* C'est tout. Question suivante ? :-)
*
*/

function NoSpamQuestion($mode = 'ask', $answer = 0)
	{
		$array_pictures = array(); $j = 0;
 
		$array_pictures[$j]['num'] = $j;
		$array_pictures[$j]['question'] = "La multiplication de 4 par 4 donne ...";
		$array_pictures[$j]['answer'] = "seize";
		$j++;
	
		$array_pictures[$j]['num'] = $j;
		$array_pictures[$j]['question'] = "La multiplication de 2 par 2 donne ...";
		$array_pictures[$j]['answer'] = "quatre";
		$j++;

		$array_pictures[$j]['num'] = $j;
		$array_pictures[$j]['question'] = "Quelle est la cinquième lettre du mot Milhie";
		$array_pictures[$j]['answer'] = "i";
		$j++;

		$array_pictures[$j]['num'] = $j;
		$array_pictures[$j]['question'] = "Le soleil est-il chaud ou froid ?";
		$array_pictures[$j]['answer'] = "chaud";
		$j++;

		$array_pictures[$j]['num'] = $j;
		$array_pictures[$j]['question'] = "Ecrire 12 en lettres";
		$array_pictures[$j]['answer'] = "douze";
		$j++;
 
		if ($mode != 'ans') // mode : 'ask'
		{
			// on est en mode 'tirer au sort', on tire une image aléatoire
			$lambda = rand(0, count($array_pictures)-1);
			return $array_pictures[$lambda];
		}
		else
		{
			// on demande une vraie réponse
			foreach($array_pictures as $i => $array)
			{
				if ($i == $answer)
				{
					return $array;
					break;
				};
			};
		}; // Fin if ($mode != 'ans')
	}
?>