<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ExerciceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Exercices');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="exercice-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Exercice'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            ['attribute' => 'canevas_id', 'value' => function($model){ return $model->canevas->nom; } ],
            ['attribute' => 'rapport_id', 'value' => function($model){ return $model->rapport->nom; } ],
            ['attribute' => 'unite_id', 'value' => function($model){ return $model->unite->nom; } ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
