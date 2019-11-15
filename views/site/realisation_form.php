<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

use app\models\Canevas;
use app\models\Rapport;
use app\models\Unite;
use app\models\Indicateur;

use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Exercice */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $array_exercice_id=[]; ?>
 <?php foreach ($realisation as $rel): ?>
<?php


   $array_exercice_id=$rel->exercice->id;

	//$indicateurs = Indicateur::find()->where(['canvevas_id' => $realisation->exercice->canevas_id])->all();

 ?>
  <?php endforeach; ?>
  <?php foreach ($realisation as $rel): ?>
  	<?php 
  		$indicateurs = Indicateur::find()->where(['canvevas_id' => $rel->exercice->canevas_id])->all();
  	?>
  <?php endforeach; ?>
<div class="row exercice-form">

  <?php $form = ActiveForm::begin(); ?>

    <?php foreach ($realisation as $rel): ?>
        <div class="col-md-6">
    <?= $form->field($rel, 'prevue')->textInput()->label($rel->indicateur->nom.'prévue') ?>
    </div>
     <div class="col-md-6">
    <?= $form->field($rel, 'realise')->textInput()->label($rel->indicateur->nom.'realisée')?>
    </div>
       <?php endforeach; ?>
</div>
<div class="exercice-form">

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>



  

  

</div>