<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\IndicateurSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Indicateurs');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="indicateur-index">

    <h1><?= Html::encode($this->title) ?></h1>
   <div class="row">
        <div class="col-md-6">
           <?= Html::a(Yii::t('app', 'Create Indicateur'), ['create'], ['class' => 'btn btn-success']) ?>
        </div>
        <div class="col-md-6">
            <div class="pull-right">

                   
                <?php $form = ActiveForm::begin([
                    'action' => Url::to(['indicateur/import']), 
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
            'description:ntext',
            'type',
            'unite_mesure',
            ['attribute' => 'requis', 'value' => function($model){ return $model->getRequis(); } ],
            ['attribute' => 'canvevas_id', 'value' => function($model){ return $model->canvevas->nom; } ],



            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
