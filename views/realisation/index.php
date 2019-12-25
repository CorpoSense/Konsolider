<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RealisationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Realisations');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="realisation-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-md-6">
            <?= Html::a(Yii::t('app', 'Create Realisation'), ['create'], ['class' => 'btn btn-success']) ?>
        </div>
        <div class="col-md-6">
            <div class="pull-right">
                <?php $form = ActiveForm::begin([
                    'action' => Url::to(['realisation/import']), 
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

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            // ['class' => 'yii\grid\SerialColumn'],

            'id',
            'prevue',
            'realise',
            ['attribute' => 'indicateur_id', 'value' => function($model){ return $model->indicateur->nom; }],
            ['attribute' => 'exercice_id', 'label' => 'Rapport', 'value' => function($model){ return $model->exercice->rapport->nom; }],
            ['attribute' => 'utilisateur_id', 'value' => function($model){ return $model->utilisateur->nom; }],
            ['attribute' => 'etat', 'value' => function($model){ return $model->getEtat(); }],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
