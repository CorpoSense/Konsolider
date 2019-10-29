<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

use app\models\Utilisateur;
use app\models\Indicateur;
use app\models\Exercice;

use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Realisation */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="realisation-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'prevue')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'realise')->textInput(['maxlength' => true]) ?>

    <?php //echo $form->field($model, 'indicateur_id')->textInput() ?>
    <?= $form->field($model, 'indicateur_id')->widget(Select2::class, [
        'data' => ArrayHelper::map(Indicateur::find()->all(), 'id', 'nom')
    ]);
    ?>

    <?php //echo $form->field($model, 'exercice_id')->textInput() ?>
    <?= $form->field($model, 'exercice_id')->widget(Select2::class, [
        'data' => ArrayHelper::map(Exercice::find()->all(), 'id', 'id')
    ]);
    ?>

    <?php //echo $form->field($model, 'utilisateur_id')->textInput() ?>
    
    <?= $form->field($model, 'utilisateur_id')->widget(Select2::class, [
        'data' => ArrayHelper::map(Utilisateur::find()->all(), 'id', 'nom')
    ]);
    ?>

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
