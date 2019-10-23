<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Unite */
/* @var $form ActiveForm */
?>
<div class="site-amar">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'nom') ?>
        <?= $form->field($model, 'responsable') ?>
        <?= $form->field($model, 'created_at') ?>
        <?= $form->field($model, 'updated_at') ?>
    
        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- site-amar -->
