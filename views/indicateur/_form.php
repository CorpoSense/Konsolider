<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

use app\models\Canevas;

use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Indicateur */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="indicateur-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nom')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'unite_mesure')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'requis')->widget(Select2::class, [
        'data' => [
            0 => 'Non',
            1 => 'Oui'
        ]
    ]) ?>

    <?= $form->field($model, 'canvevas_id')->widget(Select2::class, [
        'data' => ArrayHelper::map(Canevas::find()->all(), 'id', 'nom'),
        'pluginOptions' => [
            'allowClear' => false
        ]
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
