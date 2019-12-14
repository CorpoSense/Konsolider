<?php
use yii\helpers\Url;
use yii\jui\ProgressBar;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\models\Exercice;
use app\models\Realisation;
use app\models\Rapport;
use app\models\Unite;
use app\models\Canevas;
use  yii\grid\GridView;
use yii\helpers\Html;  


use yii\data\ActiveDataProvider;
$formatter = \Yii::$app->formatter;

?>

<div class="row">
    <div class="col-md-12">
        <div class="page-header">
            <h4>
                Exercice en cours: <?= count($exercices)>0?(Yii::$app->formatter->format($exercices[0]->rapport->debut, ['date', 'format' => 'yyyy'])):'<aucun>' ?>
                
            </h4>
        </div>
        <?php
        $list= Yii::$app->db->createCommand('select * from rapport')->queryAll();
     ?>
<?php 

 

  $data[] = $exercices;

?>
<?php 
/*$dataProvider = new ActiveDataProvider([
    'query' => Exercice::find(),
]);*/
?>
<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
 
            'id',
            [
            'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
            'label' => 'Canevas',
            'value' => function ($data) {
               return $data->canevas->nom ;
            },
            'filter' => Html::activeDropDownList($searchModel, 'canevas_id',$canevas,               ['class'=>'form-control','prompt'=>'chosir Canevas'])
         ],
            [
                'class' => 'yii\grid\DataColumn',
                'header' => 'Unite',
                'value' => function ($data) {
               return $data->unite->nom ;
            } ,
                'filter' => Html::activeDropDownList($searchModel, 'unite_id',$unite,               ['class'=>'form-control','prompt'=>'chosir unite'])
            ],
  
            [
                'label' => 'Taux davenacement ',
                'format' => 'raw',
                'value' => function ($data) {
                    // striped animated
                  switch ($data->getProgression()) {
                    case $data->getProgression()>70:
                       return \yii\bootstrap\Progress::widget(
                        [
                           
                              'percent' => $data->getProgression(),
                              'barOptions' => ['class' => 'progress-bar-success'],
                                
                            
                            
                        ]
                    );
                      break;
                    case $data->getProgression()>30:
                       return \yii\bootstrap\Progress::widget(
                        [
                           
                              'percent' => $data->getProgression(),
                              'options' => ['class' => 'progress-bar-warning'],
                        ]
                    );
                      break;
                    case $data->getProgression()<30:
                       return \yii\bootstrap\Progress::widget(
                        [
                           
                              'percent' => $data->getProgression(),
                            'barOptions' => ['class' => 'progress-bar-danger']
                            
                            
                        ]
                    );
                      break;
                    
                    default:
                      # code...
                      break;
                  }
                   
                   
                 
                },
            ],
        

            
 
           
        ],
    ]); ?>
 
