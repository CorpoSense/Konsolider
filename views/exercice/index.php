<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ExerciceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Exercices');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="exercice-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="row">
        <div class="col-md-6">
         <?= Html::a(Yii::t('app', 'Create Exercice'), ['create'], ['class' => 'btn btn-success']) ?>
        </div>
        <div class="col-md-6">
            <div class="pull-right">

                <?php $form = ActiveForm::begin([
                    'action' => Url::to(['unite/import']), 
                    'options' => [
                        'enctype' => 'multipart/form-data', 
                        'class'=>'form-inline']
                    ]) ?>
                <?= $form->field($modelUpload, 'file')->fileInput() ?>
                <?= Html::submitInput(Yii::t('app', 'import XLSX'), ['class' => 'btn btn-sm btn-info']) ?>
                 <?= Html::a(Yii::t('app', 'Export XLSX'), ['export'], ['class' => 'btn btn-sm btn-primary']) ?>
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
            ['attribute' => 'canevas_id', 'value' => function($model){ return $model->canevas->nom; } ],
            ['attribute' => 'rapport_id', 'value' => function($model){ return $model->rapport->nom; } ],
            ['attribute' => 'unite_id', 'value' => function($model){ return $model->unite->nom; } ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
