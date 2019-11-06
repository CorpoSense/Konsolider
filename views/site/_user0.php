<div class="row">
    <div class="col-md-12">
        <div class="page-header">
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-6">
                        <h4>
                            Rapport(s) en cours: <?= count($exercices) ?>
                        </h4>
                    </div>
                    <div class="pull-right">
                        <h4>Unite: <?= count($exercices)>0? $exercices[0]->unite->nom:'' ?></h4>
                    </div>
                </div>
            </div>

        </div>
        
        <div class="container">
            <div class="col-md-12">
                
                <?php $items = []; ?>
                <?php foreach ($exercices as $exercice): ?>
                    <?php array_push($items, [
                        'label' => $exercice->canevas->nom.': '.$exercice->rapport->nom/*.' ('.Yii::$app->formatter->format($exercice->rapport->fin, ['date', 'format' => 'dd-M-yyyy']).')'*/, 
                        'content' => $this->render('_canevas', ['exercice' => $exercice])
                        ]); ?>
                <?php endforeach; ?>
                
                <?= \yii\bootstrap\Tabs::widget(['items' => $items]) ?>                
                
            </div>


        </div>

    </div>
</div>
<?php $this->registerJsFile('@web/js/userpage.js', ['depends' => 'yii\web\JqueryAsset']); ?>