<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\Json;
/*$json_string = json_encode($results, JSON_PRETTY_PRINT);
           echo $json_string;*/

$formatter = \Yii::$app->formatter;

$rapports = [];
foreach ($exercices as $exercice){
    $rapport = $exercice->rapport;
    if (!key_exists($rapport->id, $rapports)){
        $rapports[$rapport->id] = $rapport->nom;
    }

}
?>
   <div class="row">
    <div class="col-md-12">
    <?php $form = ActiveForm::begin(['layout' => 'horizontal'/*, 'method' => 'get'*/]) ?>
        <?= $form->field($filterModel, 'rapport_id')->widget(Select2::classname(), [
            'data' => $rapports,
            'options' => [
                'class' => 'btn btn-primary',
                'placeholder' => 'Sélectionner un rapport...'
                ],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]) ?>
   
              
      
    <div class="col-md-6 col-md-offset-3">
        <div class="form-group pull-right">  
            <?= Html::submitButton(Yii::t('app', 'Filtrer'), ['class' => 'btn btn-success']) ?>
        </div>
    </div>
    <?php $form::end(); ?>
</div>
    <table id="listUnit" class="table table-hover">
        <thead>
        <tr>
            <th>Nom_Rapport</th>
            <th>Nom_indicateur</th>
            <th>Som_Prevue</th>
            <th>Som_Realiser</th>
        </tr>
        </thead>
        <tbody>

    
  
          <?php foreach ($results as $result): ?>

            <tr>
                <td><p><?= $result['nom_rapport'] ?></p></td>
                <td><p><?= $result['nom_indicateur'] ?></p></td>
                <td><p><?= $result['sum_indicateur_prevue'] ?></p></td>
                <td><p><?= $result['sum_indicateur_realise'] ?></p></td>               
            </tr>

            <?php endforeach; ?>

      <!-- end of foreach $exercices -->

        </tbody>
    </table>

    </div><!-- .col-md-6 -->
</div><!-- .row -->
