<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

use app\models\Unite;
use app\models\User;

use kartik\select2\Select2;


/* @var $this yii\web\View */
/* @var $model app\models\Utilisateur */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="utilisateur-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nom')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'prenom')->textInput(['maxlength' => true]) ?>

    <?php //echo $form->field($model, 'unite_id')->textInput() ?>
    
    <?= $form->field($model, 'unite_id')->widget(Select2::class, [
        'data' => ArrayHelper::map(Unite::find()->all(), 'id', 'nom'),
//        'language' => 'fr',
//        'options' => ['placeholder' => 'Choisir une Unité'],
        'pluginOptions' => [
            'allowClear' => false
        ]
    ]);
    ?>
    
    <?php //echo $form->field($model, 'user_id')->textInput() ?>
    
    <?= $form->field($model, 'user_id')->widget(Select2::class, [
        'data' => ArrayHelper::map(User::find()->all(), 'id', 'username')
    ]);
    ?>
    

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
