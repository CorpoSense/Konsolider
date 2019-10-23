<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Realisation */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="realisation-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'prevue')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'realise')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'mesure_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'exercice_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'utilisateur_id')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
