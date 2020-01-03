<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Unite;
use app\models\Exercice;
use app\models\Rapport;
use app\models\Realisation;
use app\models\Indicateur;
use app\models\Utilisateur;
use yii\helpers\Json;


class KonsoliderController extends \yii\web\Controller
{
    public function actionIndex()
    {
            $filterModel = new \app\models\FilterForm();
             if (!Yii::$app->user->isGuest){
            
            if (Yii::$app->user->identity->isAdmin()){
                // role == "admin"
                $query = Exercice::find();
                if ($filterModel->load(Yii::$app->request->post()) && $filterModel->validate()){
                        $query->andFilterWhere(['rapport_id' => $filterModel->rapport_id])
                              ;
                }

               $exercices = $query->orderBy('unite_id')->all();
                
            }
          }
    //tableau de tous les resultat des unité du meme rapport
            $array_result=array();
        	  $array_report_id=array();
        	  $records = Realisation::find()->all();
    //get all the report
            $array_report=Rapport::find()->all();
    //get all the indicateur
            $array_indicateur=Indicateur::find()->all();
    //get the same id of exercices in same array
          foreach ($array_report as $report) {
              $array_exercice=Exercice::find('id')->where(['rapport_id'=>$report->id])->all();
            foreach ($array_exercice as $exercice) {
             
              $array_report_id[]=$exercice->id;

            }
           
           
           foreach($array_indicateur as $indicateur){
            
              $sum_indicateur_prevue=Realisation::find()->where(['exercice_id'=>$array_report_id,'indicateur_id'=>$indicateur->id])->sum('prevue');
              $sum_indicateur_realise=Realisation::find()->where(['exercice_id'=>$array_report_id,'indicateur_id'=>$indicateur->id])->sum('realise');
              $rel=Indicateur::find()->where(['id'=>$indicateur->id])->one();
              $rapport=Realisation::find()->where(['exercice_id'=>$array_report_id,'indicateur_id'=>$indicateur->id])->one();
            if($sum_indicateur_prevue>0){
              $array_result_temp=array();
              $array_result_temp["nom_rapport"]=$rapport->exercice->rapport->nom;
              $array_result_temp["nom_indicateur"]=$rel->nom;
              $array_result_temp["sum_indicateur_prevue"]=$sum_indicateur_prevue;
              $array_result_temp["sum_indicateur_realise"]=$sum_indicateur_realise;
              $array_result[] = $array_result_temp;
            } 
           }
              $array_report_id=[];
          }
      
           $json_string = json_encode($array_result, JSON_PRETTY_PRINT);
           echo $json_string;
            return $this->render('index', [
            'results' => $array_result,
             'filterModel' => $filterModel,
             'exercices'=>$exercices
        ]);
    }

}
