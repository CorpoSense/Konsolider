<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Utilisateur */

$this->title = Yii::t('app', 'Create Utilisateur');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Utilisateurs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="utilisateur-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
