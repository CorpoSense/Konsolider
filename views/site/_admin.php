<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;

$formatter = \Yii::$app->formatter;

$rapports = [];
$canevas = [];
$unites = [];
foreach ($exercices as $exercice){
    $rapport = $exercice->rapport;
    if (!key_exists($rapport->id, $rapports)){
        $rapports[$rapport->id] = $rapport->nom;
    }
    $caneva = $exercice->canevas;
    if (!key_exists($caneva->id, $canevas)){
        $canevas[$caneva->id] = $caneva->nom;
    }
    $unite = $exercice->unite;
    if (!key_exists($unite->id, $unites)){
        $unites[$unite->id] = $unite->nom;
    }
}
?>
    <div class="row">
        <div class="page-header">
            <h4>Tableau de board: <?= count($exercices)>0?(Yii::$app->formatter->format($exercices[0]->rapport->debut, ['date', 'format' => 'yyyy'])):'<aucun>' ?></h4>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?php $form = ActiveForm::begin([
                'layout' => 'horizontal',
                'fieldConfig' => [
                    'template' => "<div class=\"form-md-line-input\">{beginWrapper}\n{input}<div class=\"form-control-focus\"> </div>\n{error}\n</div>{endWrapper}",
                    'horizontalCssClasses' => [
                        'label' => '',
                        'offset' => '',
                        'wrapper' => 'col-sm-12',
                        'error' => 'has-error',
                        'hint' => 'help-block',
                    ],
                ],                
                /*, 'method' => 'get'*/
                ]) ?>
        <div class="row">
            <div class="col-md-4">
                <?= $form->field($filterModel, 'rapport_id', ['options' => ['class'=> 'col-sm-12'] ])->widget(Select2::classname(), [
                    'data' => $rapports,
                    'options' => [
                        'placeholder' => 'Sélectionner un rapport...'
                        ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label(false) ?>
            </div>
            <div class="col-md-4">
                <!--<label class="control-label" for="unite_id">Unité:</label>-->
                <?= $form->field($filterModel, 'unite_id')->widget(Select2::classname(), [
                    'data' => $unites,
                    'options' => ['placeholder' => 'Sélectionner l\'unité...'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label(false) ?>        

            </div>
            <div class="col-md-4">
                <?= $form->field($filterModel, 'canevas_id')->widget(Select2::classname(), [
                    'data' => $canevas,
                    'options' => ['placeholder' => 'Sélectionner le canevas...'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label(false) ?>
            </div>
        </div><!-- .row -->
        <div class="row">
            <div class="col-md-12 pull-right">
                <div class="form-group pull-right">  
                    <?= Html::submitButton(Yii::t('app', 'Filtrer'), ['class' => 'btn btn-success']) ?>
                </div>
            </div>
        </div><!-- .row -->
        <?php $form::end(); ?>
        </div>
    </div><!-- .row -->
<br>
<div class="row">
    <div class="col-md-12">
<!--        <div class="page-header">
            <h4>
                Exercice en cours: <?= count($exercices)>0?(Yii::$app->formatter->format($exercices[0]->rapport->debut, ['date', 'format' => 'yyyy'])):'<aucun>' ?>
            </h4>
        </div>-->
    <table id="listUnit" class="table table-hover">
        <thead>
        <tr>
            <th>Unite</th>
            <th>Canevas</th>
            <th>Progression</th>
            <th>Détails</th>
        </tr>
        </thead>
        <tbody>

          <!-- <?= count($exercices) ?> -->

          <?php foreach ($exercices as $exercice): ?>

            <tr>
                <td><?= $exercice->unite->nom ?></td>
                <td>
                    <p><?= $exercice->canevas->nom ?></p>
                </td>
                <td>
                  <div class="progress">
                      <?php $progress = $exercice->getProgression() ?>
                    <div class="progress-bar progress-bar-<?= $progress < 70?($progress <30?'danger':'primary'):'success' ?>" 
                         role="progressbar" style="width: <?= $progress ?>%;">
                      <?= $formatter->asPercent($progress/100, 0) ?>
                    </div>
                  </div>

                </td>
                <td>
                    <a href="<?= Url::to(['exercice/view', 'id' => $exercice->id ]) ?>" 
                       class="btn btn-info btn-sm"> <span class="glyphicon glyphicon-pencil"></span> </a>
                </td>
            </tr>

            <?php endforeach; ?>

      <!-- end of foreach $exercices -->

        </tbody>
    </table>

    </div><!-- .col-md-6 -->
</div><!-- .row -->
