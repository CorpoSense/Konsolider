<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

use app\models\Canevas;
use app\models\Rapport;
use app\models\Unite;
use app\models\Indicateur;

use kartik\select2\Select2;
$this->title = Yii::t('app', 'Create Realisation form');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Realisation From'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
/* @var $this yii\web\View */
/* @var $model app\models\Exercice */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $array_exercice_id=[];$button_id=0;$i=0;$test=0;$count_indicateur=0;$array_indicateur=[];$indicateurs_remplis=0 ?>
 <?php foreach ($realisation as $rel): ?>
<?php
   $button_id=$rel->exercice->id;
   $array_exercice_id=$rel->exercice->id;
 ?>
  <?php endforeach; ?>
  <?php foreach ($realisation as $rel): ?>
    <?php 
      $indicateurs = Indicateur::find()->where(['canvevas_id' => $rel->exercice->canevas_id])->all();
//this will be changed to take a count only validate values
      $count_indicateur++;
      if($rel->prevue>0)
        $indicateurs_remplis++;
      if($rel->realise>0)
        $indicateurs_remplis++;

      
    ?>
  <?php endforeach; $count_indicateur; ?>
  <?php foreach ($indicateurs as $ind): ?>
    <?php 
       //array_push(array, var)
       $array_indicateur=$ind->id;
      
    ?>
  <?php endforeach; $count_indicateur;?>


 
<div class="row exercice-form " id="<?php echo $array_exercice_id; ?>">
  <?php $form = ActiveForm::begin(
               );$count_indicateur=$count_indicateur*2;?>
               <input type="hidden" class='<?php echo $array_exercice_id-1; ?>'  value='<?php echo $count_indicateur; ?>' >
     <?php //$button_id=$button_id+100-1;?>          
  <?php foreach ($realisation as $model): ?>
      <div class="col-md-6">
      <!--champ prevue-->
          <?php if($model->etat==0){?>
          <?= $form->field($model, 'prevue')->textInput(['id'=>$i,'class'=>$button_id+100-1])->label($model->indicateur->nom.' prévue')
        ?>
        <?php }else{?>
          <?= $form->field($model, 'prevue')->textInput(['id'=>$i,'class'=>$button_id+100-1, 'placeholder' => 'Title', 'disabled' => true])->label($model->indicateur->nom.' prévue')?>
        <?php }?>
      <?php $i++; ?>
      </div>
     <div class="col-md-6">
      <!--champ realise-->
           <?php if($model->etat==0){?>
         <?= $form->field($model, 'realise')->textInput(['id'=>$i,'class'=>$button_id+100-1])->label($model->indicateur->nom.' realisée')?>
        <?php }else{?>
         <?= $form->field($model, 'realise')->textInput(['id'=>$i,'class'=>$button_id+100-1, 'placeholder' => 'Title', 'disabled' => true])->label($model->indicateur->nom.' realisée')?>
        <?php }?>
      <?php $i++; ?>
      </div>
    <?php endforeach; ?>
     <?php $form = ActiveForm::end();?>
     <?php 
     if($indicateurs_remplis==$count_indicateur )
       {
        $test=1;
        
       } 
       if($test==1){
      ?>
    
     <?php }if($test==0){?>
    <?php }?>
</div>
