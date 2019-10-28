<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Rapport */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="rapport-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nom')->textInput(['maxlength' => true]) ?>

    <?php //echo $form->field($model, 'debut')->textInput() ?>
    
    <?= $form->field($model, 'debut')->widget(DatePicker::class, [
        'type' => DatePicker::TYPE_INPUT,
        'options' => ['placeholder' =>  $model->getAttributeLabel('date_début')],
        'pluginOptions' => [
            'format' => 'yyyy-mm-dd'
        ]
    ]) ?>

    <?php //echo $form->field($model, 'fin')->textInput() ?>

    <?= $form->field($model, 'fin')->widget(DatePicker::class, [
        'type' => DatePicker::TYPE_INPUT,
        'options' => ['placeholder' =>  $model->getAttributeLabel('date_fin')],
        'pluginOptions' => [
            'format' => 'yyyy-mm-dd'
        ]
    ]) ?>
    
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
