<?php

use yii\helpers\Url;

?>

<div class="row">
    <div class="col-md-12">
        <div class="page-header">
            <h4>
                Exercice en cours: <?= count($exercices)>0?(Yii::$app->formatter->format($exercices[0]->rapport->debut, ['date', 'format' => 'yyyy'])):'<aucun>' ?>
            </h4>
        </div>
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
                      <?php $rand = rand(1,100) ?>
                    <div class="progress-bar progress-bar-<?= $rand < 70?($rand <30?'danger':'primary'):'success' ?>" role="progressbar" style="width: <?= $rand ?>%;">
                      <?= $rand ?>%
                    </div>
                  </div>

                </td>
                <td>
                    <a href="<?= Url::to(['exercice/view', 'id' => $exercice->id ]) ?>" class="btn btn-info btn-sm"> <span class="glyphicon glyphicon-pencil"></span> </a>
                </td>
            </tr>

            <?php endforeach; ?>

      <!-- end of foreach $exercices -->

        </tbody>
    </table>

    </div><!-- .col-md-6 -->
</div><!-- .row -->