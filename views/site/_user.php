<div class="row">
    <div class="col-md-12">
        <div class="page-header">
            <h4>
                Exercice en cours: <?= isset($exercice)?(Yii::$app->formatter->format($exercice->rapport->debut, ['date', 'format' => 'Y'])):'<aucun>' ?>
            </h4>
        </div>

        <table class="table table-responsive">
            <thead>
                <tr>
                    <th>Rapport</th>
                    <th>Indicateur</th>
                    <th>Prévu</th>
                    <th>Réalisé</th>
                    <th></th>
                    <th><input type="checkbox" /></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?= $exercice->rapport->nom ?></td>
                    <?php foreach ($indicateurs as $mesure) : ?>
                    <td><?= $mesure->nom ?></td>
                    <?php endforeach; ?>
                    <td><input class="form-control form-inline mesure-input" type="number" placeholder="Prévision" /></td>
                    <td><input class="form-control form-inline mesure-input" type="number" placeholder="Réalisation" /></td>
                    <td><input class="btn btn-primary btn-sm" type="button" value="Valider" /></td>
                    <td><input type="checkbox" /></td>
                </tr>
            </tbody>
        </table>

        
    </div>
</div>

<?php $this->beginBlock('footer') ?>
<script>
    $('#check-all').change(function(){
        $('.check-mesure').prop('checked', $(this).prop('checked'));
    });
    $('.mesure-input').change(function(){
        updateRate($(this));
    });
    function updateRate(el){
    var value = $(el).val();
    var id = $(el).attr('data-value');
        var result = '-';
        try {
            var forecast = parseFloat( $('#prevue-'+id).val() );
            var real =  parseFloat( $('#realise-'+id).val() );
            result = parseFloat( (real / forecast)*100 ).toFixed(1);
        } catch (e){
            result = '-';
        }
        $('#rate-mesure-input-'+id).text( isNaN(result)?'-':(result + '%') );

    }
</script>
<?php $this->endBlock('footer') ?>