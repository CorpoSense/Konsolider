<?php

use yii\helpers\Url;

?>
<form action="<?= Url::to(['site/validate']) ?>" method="post" data-async id="form-validation-<?= $exercice->canevas->id ?>">
    <input type="hidden" id="exercice-id" name="exercice-id" value="<?= $exercice->canevas->id ?>" />
    <table class="table table-responsive">
        <thead>
            <tr>
                <th>Indicateur(s)</th>
                <th>Prévu</th>
                <th>Réalisé</th>
                <th>Taux</th>
                <th><input type="checkbox" name="check-all" class="check-all" data-value="<?= $exercice->canevas->id ?>" /></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($exercice->canevas->indicateurs as $mesure): ?>
            <input type="hidden" id="mesure-id-<?= $mesure->id ?>" name="mesure-id-<?= $mesure->id ?>" value="<?= $mesure->id ?>" />
            <tr>
                <td><?= $mesure->nom.($mesure->requis?'*':'') ?>
                  <div class="help-block"><?= $mesure->description ?>
                  </div>
                </td>
                <td>
                    <input class="form-control mesure-input" data-value="<?= $mesure->id ?>" type="number" <?= $mesure->requis?'required="required"':'' ?> name="prevue-<?= $mesure->id ?>" id="prevue-<?= $mesure->id ?>"placeholder="Prévision" />
                </td>
                <td>
                    <input class="form-control mesure-input" data-value="<?= $mesure->id ?>" type="number" <?= $mesure->requis?'required="required"':'' ?> name="realise-<?= $mesure->id ?>" id="realise-<?= $mesure->id ?>" placeholder="Réalisation" />
                </td>
                <td class="rate-mesure-input"><span id="rate-mesure-input-<?= $mesure->id ?>">%</span></td>
                <td><input type="checkbox" class="check-mesure-<?= $exercice->canevas->id ?>" name="check-mesure-<?= $mesure->id ?>" id="check-mesure-<?= $mesure->id ?>" /></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="pull-right">
        <input type="submit" class="btn btn-primary btn-sm btn-validate" value="Valider" name="btn-validate-<?= $exercice->canevas->id ?>" name="btn-validate-<?= $exercice->canevas->id ?>"/>
    </div>
</form>