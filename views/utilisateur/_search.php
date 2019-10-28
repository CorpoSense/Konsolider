<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UtilisateurSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="utilisateur-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'nom') ?>

    <?= $form->field($model, 'password') ?>

    <?= $form->field($model, 'role') ?>
    
   <?php // echo $form->field($model, 'auth_key') ?>
    
   <?php // echo $form->field($model, 'access_token') ?>
   <?php // echo $form->field($model, 'unite_id') ?>    

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
