<?php

use yii\helpers\Url;
use app\models\Realisation;

$formatter = \Yii::$app->formatter;

?>

    <table class="table table-responsive">
        <thead>
            <tr>
                <th>Indicateur(s)</th>
                <th>Prévu</th>
                <th>Réalisé</th>
                <th>Taux</th>
                <th><!-- input type="checkbox" name="check-all" class="check-all" data-value="<?= $exercice->canevas->id ?>" / --></th>
            </tr>
        </thead>
        <tbody>
            
            <?php foreach ($realisations as $realisation): ?>
            <?php $mesure = $realisation->indicateur; ?>
            
            <form action="<?= Url::to(['site/confirm']) ?>" method="post" id="form-validation-<?= $exercice->canevas->id ?>">
            <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />    
            <!-- input type="hidden" id="exercice-id-<?= $exercice->id ?>" name="exercice-id-<?= $exercice->id ?>" value="<?= $exercice->id ?>" / -->
            <input type="hidden" id="realisation-id-<?= $realisation->id ?>" name="realisation-id-<?= $realisation->id ?>" value="<?= $realisation->id ?>" />
            <tr>
                <td><?= $mesure->nom.($mesure->requis?'*':'') ?>
                  <div class="help-block"><?= $mesure->description ?>
                  </div>
                </td>
                <td>
                    <input class="form-control mesure-input" <?= $realisation->etat==Realisation::ETAT_VALID?'disabled':'' ?> value="<?= $realisation->prevue ?>" data-value="<?= $mesure->id ?>" type="number" <?= $mesure->requis?'required="required"':'' ?> name="prevue-<?= $mesure->id ?>" id="prevue-<?= $mesure->id ?>" placeholder="Prévision" />
                </td>
                <td>
                    <input class="form-control mesure-input" <?= $realisation->etat==Realisation::ETAT_VALID?'disabled':'' ?> value="<?= $realisation->realise ?>" data-value="<?= $mesure->id ?>" type="number" <?= $mesure->requis?'required="required"':'' ?> name="realise-<?= $mesure->id ?>" id="realise-<?= $mesure->id ?>" placeholder="Réalisation" />
                </td>
                <td class="rate-mesure-input"><span id="rate-mesure-input-<?= $mesure->id ?>"><?= $realisation->prevue > 0? $formatter->asPercent($realisation->realise / $realisation->prevue, 1):'%' ?></span></td>
                <td>
                    <input type="submit" class="btn btn-<?= $realisation->etat==Realisation::ETAT_VALID?'primary':'success' ?> btn-sm" value="<?= $realisation->etat==Realisation::ETAT_VALID?'Validé':'OK' ?>" <?= $realisation->etat==Realisation::ETAT_VALID?'disabled':'' ?> />
                    
                    <!-- input type="checkbox" class="check-mesure-<?= $exercice->canevas->id ?>" <?= $realisation->etat==Realisation::ETAT_VALID?'disabled':'' ?> name="check-mesure-<?= $mesure->id ?>" id="check-mesure-<?= $mesure->id ?>" / -->
                </td>
            </tr>
            </form>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="pull-right hidden">
        <input type="submit" class="btn btn-primary btn-sm btn-validate" 
               value="Valider" 
               id="btn-validate-<?= $exercice->canevas->id ?>" 
               name="btn-validate-<?= $exercice->canevas->id ?>"/>
    </div>

<?php $this->registerJsFile('@web/js/userpage.js', ['depends' => 'yii\web\JqueryAsset']); ?>