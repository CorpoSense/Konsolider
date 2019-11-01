<div class="row">
    <div class="col-md-12">
        <div class="page-header">
            <h4>
                Exercice en cours: <?= isset($exercice)?(Yii::$app->formatter->format($exercice->rapport->debut, ['date', 'format' => 'Y'])):'<aucun>' ?>
            </h4>
            <h4>Unite: <?= $exercice->unite->nom ?></h4>
        </div>

        <table class="table table-responsive">
            <thead>
                <tr>
                    <th>Rapport</th>
                    <th>Indicateur</th>
                    <th>Prévu</th>
                    <th>Réalisé</th>
                    <th>Taux</th>
                    <th><input type="checkbox" name="check-all" id="check-all" /></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?= $exercice->rapport->nom ?></td>
                    <?php foreach ($indicateurs as $mesure) : ?>
                    <td><?= $mesure->nom ?>
                      <div class="help-block"><?= $mesure->description ?>
                          <input type="hidden" name="mesure-id-<?= $mesure->id ?>" id="mesure-id-<?= $mesure->id ?>" value="<?= $mesure->id ?>" />
                      </div>

                    </td>
                    <?php endforeach; ?>
                    <td><input class="form-control mesure-input" data-value="<?= $mesure->id ?>" type="number" name="prevue-<?= $mesure->id ?>" id="prevue-<?= $mesure->id ?>"placeholder="Prévision" /></td>
                    <td><input class="form-control mesure-input" data-value="<?= $mesure->id ?>" type="number" name="realise-<?= $mesure->id ?>" id="realise-<?= $mesure->id ?>" placeholder="Réalisation" /></td>
                    <td class="rate-mesure-input"><span id="rate-mesure-input-<?= $mesure->id ?>"></span></td>
                    <td><input type="checkbox" class="check-mesure" name="check-mesure-<?= $mesure->id ?>" id="check-mesure-<?= $mesure->id ?>" /></td>
                </tr>
            </tbody>
        </table>
        <div class="pull-right">
          <input class="btn btn-primary btn-sm" type="button" value="Valider" />
        </div>


    </div>
</div>
<?php $this->registerJsFile('@web/js/rates.js', ['depends' => 'yii\web\JqueryAsset']) ?>
