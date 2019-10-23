<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Unite */

$this->title = Yii::t('app', 'Update Unite: {name}', [
    'name' => $model->unite_id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Unites'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->unite_id, 'url' => ['view', 'id' => $model->unite_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="unite-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
