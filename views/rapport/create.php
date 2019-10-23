<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Rapport */

$this->title = Yii::t('app', 'Create Rapport');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Rapports'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rapport-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
