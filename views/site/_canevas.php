<table class="table table-responsive">
    <thead>
        <tr>
            <th>Indicateur</th>
            <th>Prévu</th>
            <th>Réalisé</th>
            <th>Taux</th>
            <th><input type="checkbox" name="check-all" class="check-all" data-value="<?= $canevas->id ?>" /></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($canevas->indicateurs as $mesure): ?>
        <tr>
            <td><?= $mesure->nom ?>
              <div class="help-block"><?= $mesure->description ?>
              </div>
            </td>
            <td><input class="form-control mesure-input" data-value="<?= $mesure->id ?>" type="number" name="prevue-<?= $mesure->id ?>" id="prevue-<?= $mesure->id ?>"placeholder="Prévision" /></td>
            <td><input class="form-control mesure-input" data-value="<?= $mesure->id ?>" type="number" name="realise-<?= $mesure->id ?>" id="realise-<?= $mesure->id ?>" placeholder="Réalisation" /></td>
            <td class="rate-mesure-input"><span id="rate-mesure-input-<?= $mesure->id ?>">%</span></td>
            <td><input type="checkbox" class="check-mesure-<?= $canevas->id ?>" name="check-mesure-<?= $mesure->id ?>" id="check-mesure-<?= $mesure->id ?>" /></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div class="pull-right">
  <input class="btn btn-primary btn-sm" type="button" value="Valider" />
</div>