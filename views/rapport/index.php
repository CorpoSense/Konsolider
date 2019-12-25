<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RapportSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Rapports');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rapport-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="row">
        <div class="col-md-6">
         <?= Html::a(Yii::t('app', 'Create Rapport'), ['create'], ['class' => 'btn btn-success']) ?>
        </div>
        <div class="col-md-6">
            <div class="pull-right">

                <?php $form = ActiveForm::begin([
                    'action' => Url::to(['rapport/import']), 
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
            'debut',
            'fin',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
