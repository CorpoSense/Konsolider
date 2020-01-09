<?php

/* @var $this yii\web\View */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\bootstrap\Tabs;
use kartik\select2\Select2;


$this->title = Yii::$app->name;
?>

<div class="container">
  <div class="row">
    <div class="col-md-12">
        <div class="row">
        <?php $form = ActiveForm::begin([
            'layout' => 'horizontal',
                'fieldConfig' => [
                    'template' => "<div class=\"form-md-line-input\">{beginWrapper}\n{input}<div class=\"form-control-focus\"> </div>\n{error}\n</div>{endWrapper}",
                    'horizontalCssClasses' => [
                        'label' => '',
                        'offset' => '',
                        'wrapper' => 'col-md-12',
                        'error' => 'has-error',
                        'hint' => 'help-block',
                    ],
                ],                
            /*'method' => 'get'*/
            ]) ?>
            <div class="col-md-10">
                <?= $form->field($filterModel, 'rapport_id')->widget(Select2::classname(), [
                    'data' => $rapports,
                    'options' => [
                        'placeholder' => 'Sélectionner un rapport...'
                        ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label(false) ?>
            </div>
                <?php /* echo $form->field($filterModel, 'canevas_id')->widget(Select2::classname(), [
                    'data' => $canevas,
                    'options' => ['placeholder' => 'Sélectionner le canevas...'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label(false); */?>
            <div class="col-md-2">            
                <div class="form-group">  
                    <?= Html::submitButton(Yii::t('app', 'Filtrer'), ['class' => 'btn btn-success']) ?>
                </div>
            </div>
        <?php $form::end(); ?>  
        </div>
        <br>
        <div class="row">

<?php
$items = [];
foreach ($canevas as $caneva_id => $caneva_nom) {
    array_push($items,
        [
            'label' => $caneva_nom,
            'url' => Url::to(['resultat/index', 'canevas_id' => $caneva_id]),
            'active' => ($caneva_id == $canevaId)
        ]            
    );
}

echo Tabs::widget([
    'items' => $items
]);
?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
             ['class' => 'yii\grid\SerialColumn'],
//            'exercice.indicateur',
            ['attribute' => 'indicateur_id', 'value' => function($model){ return $model->indicateur->nom; }],
            'prevue',
            'realise',
//            ['attribute' => 'exercice_id', 'label' => 'Rapport', 'value' => function($model){ return $model->exercice->rapport->nom; }],
//            ['attribute' => 'utilisateur_id', 'value' => function($model){ return $model->utilisateur->nom; }],
//            ['attribute' => 'etat', 'value' => function($model){ return $model->getEtat(); }],

//            ['class' => 'yii\grid\ActionColumn'],
        ],
        'summary'=> false
    ]); ?>
            
        </div><!-- .row -->
        
    </div><!-- .col-md-12 -->
  </div><!-- .row -->
</div><!-- .container -->
