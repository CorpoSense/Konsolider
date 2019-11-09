<?php

//aficher forumulaire realisation pour utilisateur
echo '<from>';
   
	foreach ($model as $value){
		echo "<div>";
		//prévu
		echo '<label>'.$value.'</label>';
		echo "<input type='text' placeholder='prévi' />";
		//realiser
		echo '<label>'.$value.'</label>';
		echo "<input type='text' placeholder='Réaliser' />";

		echo "</div>";
	}
	echo "<input type='submit'/>";
echo '</form>';
?>

