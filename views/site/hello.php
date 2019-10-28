<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Bienvenu';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1></h1>

     <?php var_dump($exercices) ?>
    
    <?php foreach ($exercices as $k): ?>
    
    <?php echo $k->id ?>
    
    <?php endforeach; ?>
    
</div>
