<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

use app\models\Canevas;
use app\models\Rapport;
use app\models\Unite;

use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Exercice */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="exercice-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'canevas_id')->widget(Select2::class, [
        'data' => ArrayHelper::map(Canevas::find()->all(), 'id', 'nom'),
        'pluginOptions' => [
            'allowClear' => false
        ]
    ]) ?>

    <?= $form->field($model, 'rapport_id')->widget(Select2::class, [
        'data' => ArrayHelper::map(Rapport::find()->all(), 'id', 'nom'),
        'pluginOptions' => [
            'allowClear' => false
        ]
    ]) ?>

    <?= $form->field($model, 'unite_id')->widget(Select2::class, [
        'data' => ArrayHelper::map(Unite::find()->all(), 'id', 'nom'),
        'pluginOptions' => [
            'allowClear' => false
        ]
    ]) ?>


    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
