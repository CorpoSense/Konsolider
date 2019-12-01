<?php

use yii\bootstrap\Tabs;

?>
<div class="page-header">
    <h1>Réalisations</h1>
</div>

<div class="row ">
    
    <div class="col-md-12">
        
        <?php $items = []; ?>
        
        <?php foreach ($exercices as $exercice): ?>

            <?php 
            // find corresponding $realisation for each $exercice
            $exercice_realisations = [];
            foreach ($realisations as $realisation){
                if ($realisation->exercice_id == $exercice->id){
                    array_push($exercice_realisations, $realisation);
                }
            }
            array_push($items, [
                'label' => $exercice->rapport->nom.' ('.$exercice->canevas->nom.')',
                'content' => $this->render('_canevas', ['exercice' => $exercice, 'realisations' => $exercice_realisations]) //$exercice->id
            ]); ?>

        <?php endforeach; ?>
        
        <?= Tabs::widget(['items' => $items ]) ?>
        
    </div><!-- .row -->
</div>