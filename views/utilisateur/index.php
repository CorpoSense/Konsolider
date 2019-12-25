<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UtilisateurSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Utilisateurs');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="utilisateur-index">

    <h1><?= Html::encode($this->title) ?></h1>
       <div class="row">
        <div class="col-md-6">
         <?= Html::a(Yii::t('app', 'Create Utilisateur'), ['create'], ['class' => 'btn btn-success']) ?>
        </div>
        <div class="col-md-6">
            <div class="pull-right">

                    
                <?php $form = ActiveForm::begin([
                    'action' => Url::to(['utilisateur/import']), 
                    'options' => [
                        'enctype' => 'multipart/form-data', 
                        'class'=>'form-inline']
                    ]) ?>
                <?= $form->field($modelUpload, 'file')->fileInput() ?>
                 <?= Html::a(Yii::t('app', 'Export XLSX'), ['export'], ['class' => 'btn btn-sm btn-primary']) ?>
                <?= Html::submitInput(Yii::t('app', 'import XLSX'), ['class' => 'btn btn-sm btn-info']) ?>
                <?php ActiveForm::end() ?>
                   
            </div>
                   
            </div>
            
        </div>
    </div>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            // ['class' => 'yii\grid\SerialColumn'],

            'id',
            'nom',
            'prenom',
            ['attribute' => 'unite_id', 'value' => function ($model) { return $model->unite->nom; }],
            ['attribute' => 'user_id', 'label' => 'Access', 'value' => function ($model) { return $model->user->username; }],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
