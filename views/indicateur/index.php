<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\IndicateurSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Indicateurs');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="indicateur-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Indicateur'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

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
