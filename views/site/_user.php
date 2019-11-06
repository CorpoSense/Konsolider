<div class="page-header">
    <h1>Réalisations</h1>
</div>

<div class="row ">
    
    <div class="col-md-12">
        <?php $items = [] ?>
            <?php foreach ($realisations as $realisation): ?>
                <?php //echo var_dump($realisation->toArray()) ?>
                <?php array_push($items, [
                    'label' => $realisation->exercice->rapport->nom,
                    'content' => $realisation->id
                    
                ]); ?>
            <?php endforeach; ?>
                <?php echo \yii\bootstrap\Tabs::widget([
                        'items' => $items
                    ]); ?>
        
    </div><!-- .row -->
</div>