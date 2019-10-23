<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Exercice */

$this->title = Yii::t('app', 'Create Exercice');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Exercices'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="exercice-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
