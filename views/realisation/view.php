<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Realisation */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Realisations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="realisation-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'prevue',
            'realise',
            ['attribute' => 'indicateur_id', 'value' => function($model){ return $model->indicateur->nom; }],
            ['attribute' => 'exercice_id', 'label' => 'Rapport', 'value' => function($model){ return $model->exercice->rapport->nom; }],
            ['attribute' => 'utilisateur_id', 'value' => function($model){ return $model->utilisateur->nom; }],
            ['attribute' => 'etat', 'value' => function($model){ return $model->getEtat(); }],
        ],
    ]) ?>

</div>
