<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Realisation */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="realisation-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'prevue')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'realise')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'indicateur_id')->textInput() ?>

    <?= $form->field($model, 'exercice_id')->textInput() ?>

    <?= $form->field($model, 'utilisateur_id')->textInput() ?>

    <?php //echo $form->field($model, 'etat')->textInput() ?>

    <?= $form->field($model, 'etat')->widget(Select2::class, [
        'data' => [
            0 => 'Non Valide',
            1 => 'Valide',
        ]
    ]);
    ?>
        
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
