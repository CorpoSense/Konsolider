<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RealisationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Realisations');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="realisation-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Realisation'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'prevue',
            'realise',
            ['attribute' => 'indicateur_id', 'value' => function($model){ return $model->indicateur->nom; }],
            ['attribute' => 'exercice_id', 'label' => 'Rapport', 'value' => function($model){ return $model->exercice->rapport->nom; }],
            ['attribute' => 'utilisateur_id', 'value' => function($model){ return $model->utilisateur->nom; }],
            //'etat',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
