<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Realisation */

$this->title = Yii::t('app', 'Create Realisation');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Realisations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="realisation-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
