<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Exercice */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="exercice-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'canevas_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'rapport_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'unite_id')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
