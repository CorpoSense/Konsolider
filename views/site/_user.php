<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

use app\models\Exercice;
use app\models\Realisation;

/* @var $this yii\web\View */
/* @var $model app\models\Indicateur */
/* @var $form yii\widgets\ActiveForm */
//i'm using in this user form some temparary array to get firstable the exercice_id after that i affect them to array_relaisation_id and i use that array to extract all the indicateru of the same exercice from a sql request where i get an array of relaisation that i sent it to a view called realisation_form where each tab will render the indicateur of same exercice of certain rapport(done in the controller of ActionIndex)
//still didn't save the data 
?>
<div class="page-header">
    <h1>Réalisations</h1>
</div>

<div class="row ">
<!--an array to split the realisation form by the same groupe of id-->
    <?php 
         $array_realisation_id=[];
         $i=0;
       foreach ($realisations as $realisation): 
                
                $array_realisation_id[$i]=$realisation->exercice_id;
                $i++;
                
         endforeach; 
         $array_realisation_id=array_unique($array_realisation_id);    
              //$exercice = Exercice::find()->where(['id' => $contenu])->all()
     ?>
  <div class="container">
    <div class="col-md-12">
        <?php $form = ActiveForm::begin(); ?>
        <?php $items = [];$array_realisation=[] ?>
            <?php foreach ($array_realisation_id as $value): ?>
                <?php
               
                 $array_realisation[]= Realisation::find()->where(['exercice_id' => $value])->all();?>
            <?php endforeach; ?>
            <?php foreach ($array_realisation as $realisation): ?>
                <?php
                $items[]= [
                    'label' => $realisation[0]->exercice->rapport->nom,
                    'content' =>  $this->render('realisation_form', ['realisation' => $realisation])
                ];
         
                ?>
                <?php endforeach; ?>
               
            
                <?php echo \yii\bootstrap\Tabs::widget([
                        'items' => $items
                    ]); ?>
                    <?php $form = ActiveForm::end(); ?>
        
    </div><!-- .row -->
</div>
</div>