<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\RealisationSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="realisation-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'prevue') ?>

    <?= $form->field($model, 'realise') ?>

    <?= $form->field($model, 'indicateur_id') ?>

    <?= $form->field($model, 'exercice_id') ?>

    <?php // echo $form->field($model, 'utilisateur_id') ?>

    <?php // echo $form->field($model, 'etat') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
