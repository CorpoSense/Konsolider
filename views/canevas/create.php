<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Canevas */

$this->title = Yii::t('app', 'Create Canevas');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Canevas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="canevas-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
