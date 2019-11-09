<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;


foreach ($canvas as $value){
	echo "<div>";
	echo '<a href='.Url::toRoute(
		[
		'exercice/fill',
		'id'   =>$value->canevas_id,
		'debut'=>$value->rapport->debut,
		'fin'  =>$value->rapport->fin
	])
	.'>'.'canevas'.$value->canevas_id."</a>";
	echo "</div>";
}

?>