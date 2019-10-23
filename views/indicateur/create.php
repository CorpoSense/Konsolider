<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Indicateur */

$this->title = Yii::t('app', 'Create Indicateur');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Indicateurs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="indicateur-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
