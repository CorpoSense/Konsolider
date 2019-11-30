<?php
use yii\helpers\Url;
use yii\bootstrap\Progress;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\models\Exercice;
use app\models\Realisation;
use app\models\Rapport;


?>

    <?php $form = ActiveForm::begin(); ?>
    <?php
        $list= Yii::$app->db->createCommand('select * from rapport')->queryAll();
     ?>
    
    <?= $form->field($rapport[0], 'id')->dropDownList(
        ArrayHelper::map($list, 'id', 'debut'),
        [
            'prompt' => 'Select Rapport',
            'onchange' => '
                $.post("index.php?r=site/search&id='.'"+$(this).val(), function(data){
                    //$("tbody").html(data);
                });'
        ]
    )->label("année")
     ?>
      <?php ActiveForm::end(); ?>
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
            <th>Pourcentage</th>
            <th>Progression</th>
            <th>Détails</th>
        </tr>
        </thead>
        <tbody>

          <!-- <?= count($exercices) ?> -->
        
          <?php foreach ($exercices as $exercice): ?>
            <?php 
            $percent=0; 
                   $countrealisations = Realisation::find()->where(['exercice_id' => $exercice->id])->count()*2;
                 $realisations= Realisation::find()->where(['exercice_id' => $exercice->id])->all();
                foreach ($realisations as $realisation){
                    if($realisation->prevue!=0)
                        $percent++;
                    if($realisation->realise!=0)
                        $percent++;
                }
            if($percent==0)
                {
                    $percent=0;
                }
            else
                    {
                        $percent= ($percent/$countrealisations)*100;
                    }
            ?>
            <tr>
                <td><?= $exercice->unite->nom ?></td>
                <td>
                    <p><?= $exercice->canevas->nom ?></p>
                </td>
                <td>
                    <p><?= $percent.'%';?></p>
                </td>
                <td>
                <?php switch ($percent) {
                        case $percent==100:
                            echo Progress::widget([
                            'percent' =>$percent,
                            'barOptions' => ['class' => 'progress-bar-success']
                           
                        ]);

                            break;
                        case $percent>60:
                             echo Progress::widget([
                            'percent' =>$percent,
                            'barOptions' => ['class' => 'progress-bar-primary'],
                           
                        ]);
                            break;
                         case $percent>30:
                             echo Progress::widget([
                            'percent' =>$percent,
                            'barOptions' => ['class' => 'progress-bar-danger'],
                           
                        ]);
                            break;
                        
                    }
                       
             
                 ?>
       
                  <!--<div class="progress">
                      <?php $rand = rand(1,100) ?>
                    <div class="progress-bar progress-bar-<?= $rand < 70?($rand <30?'danger':'primary'):'success' ?>" role="progressbar" style="width: <?= $rand ?>%;">
                      <?= $rand ?>%
                    </div>
                  </div>

                </td>-->
                
                <td>
                    <a href="<?= Url::to(['exercice/view', 'id' => $exercice->id ,'unite_id'=>$exercice->unite->id,]) ?>" class="btn btn-info btn-sm"> <span class="glyphicon glyphicon-pencil"></span> </a>
                
                    <a href="<?= Url::to(['site/detail', 'id' => $exercice->id ]) ?>" class="btn btn-success btn-sm"> <span class="glyphicon glyphicon-search"></span> </a>
                </td>
            </tr>

            <?php endforeach; ?>

      <!-- end of foreach $exercices -->

        </tbody>
    </table>

    </div><!-- .col-md-6 -->
</div><!-- .row -->