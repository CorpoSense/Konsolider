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
use app\models\Realisation;
use app\models\Indicateur;
use app\models\Utilisateur;
use app\models\Rapport;

class SiteController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                //'only' is used for actionLogout()
                'only' => ['logout','b'],
                //are applied for the selected action
                'rules' => [
                    [
                        //
                        'actions' => ['logout','b'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                    'b' => ['post','get'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
     public function actionB()
    { 
        $res = (object)array("success"=>false);
        $array_indicateur=[];
        $i=0;
        $realiser=[];
        $prevue=[];
        $realiser = $_POST['realiser'];
        $prevue = $_POST['prevue'];
        $exercice_id=$_POST['exercice_id'];
        echo $exercice_id;
        echo $realiser[0];
        $user_id=$_POST['user_id'];
        $exercice = Exercice::find()->where(['id' => $exercice_id])->all();
         $indicateurs = Indicateur::find()->where(['canvevas_id' => $exercice[0]->canevas_id])->all();
           foreach ($indicateurs  as $indicateur){
            //if($model->etat==1)
               // return 0;
            $model = Realisation::find()->where(
                [
                    'indicateur_id' => $indicateur->id,
                    'utilisateur_id'=>$user_id,
                    'exercice_id'=>$exercice_id
                ])->one();
            $model->prevue =$realiser[$i];
            $model->realise=$prevue[$i];
            $i++;
            if($model->etat==0){
                echo "string";
                $model->etat=1;
                $model->save();
            }
        }   
    }
    public function actionIndex()
    { 
//un tableau pour sauvgarder
        $user = Utilisateur::getConnectedUser();
        $contenu=[];
        $user_id;
        $array_exercice_id=[];
        $i=0;
        $realisations =array();
          if (Yii::$app->user->isGuest) {
             return $this->redirect(['site/login']);
          }
//récuperer la date actuelle
        $date=date('Y');       
        $date_now= date('Y', strtotime($date));
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
              return $this->goBack();
        }
//création de tableau exercice
        $exercices = [];
        if (isset(Yii::$app->user->identity)){
            if (Yii::$app->user->identity->isAdmin()){
                // role "admin"
                $exercices = Exercice::find()->orderBy('unite_id')->all();

            } else {
                // role "user"
                
//modification by amar Hi this the lines that i've adeded
                //get all the report
                $rapports=Rapport::find()->all();
//the purpose is to get all the reports of the year
                foreach ($rapports as $rapport) {
                    
                    $contenu=array($rapport->id);
                    $contenu=array_unique($contenu);
//get the year of the report date 
                    $date_debut=date('Y', strtotime($rapport->debut));
//condition check if the start_date is in the same actuall year
                    if($date_debut==$date_now){
                        
                       $exercices = Exercice::find()->where(['unite_id' => $user->unite->id,'rapport_id'=>$rapport->id])->all();
                    }
//store the exercice_id in array_exercices_id
                    foreach ($exercices as $exercice) {
                        $array_exercice_id[$i]= $exercice->id;
                        $i++;
                    }
//
                if (count($exercices) > 0){                            
                    foreach ($exercices as $exercice) {
 // TODx@O: add only the realisations needed in case when only some of them are added
// for each $exercice check if a realisation hasn't been created yet
                        $realisations = Realisation::find()->where(['exercice_id' => $exercice->id])->all();
                        if (empty($realisations)){
                            // if so, create one
                            $indicateurs = $exercice->canevas->indicateurs;
                            foreach ($indicateurs as $indicateur) {
                                $savedRealisation = $this->createRealisation($exercice->id, $indicateur->id, 0.0, 0.0, $user->id, Realisation::ETAT_NONVALID);

                                $realisations[]= $savedRealisation;

                            } //foreach
                        } //if
                    } //foreach
                } // 
                }
//get only the realisation of the exercice of certain rapport of certain unite authentified the condition used in where is the exercice_id of all the report of the actuall year
                $realisations = Realisation::find()->where(['exercice_id' => $array_exercice_id])->all();
                 return $this->render('index', [
                    'model' => $model,
                    'realisations' => $realisations,
                    'amar'=>$user->id
                ]);
                
            }
        }
        return $this->render('index', [
            'model' => $model,
            'exercices' => $exercices,
            'amar'=>"",
            'realisations' => $realisations
        ]);
    }
    public function actionDetail($id)
    {
        echo  $_GET['id'];
        $realisations = Realisation::find()->where(['exercice_id' => $id])->all();
       
        return $this->render('detail', [
                    'model' => "",
                    'realisations' => $realisations,
                    'amar'=>""
                ]);
    }
      public function actionSearch($id)
    {
        return $this->render('index', [
                    'exercices' => [],
                    'realisations' => [],
                    'amar'=>""
                ]);
    }
    public function actionLogin()
    {
               if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);

    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    public function actionAbout()
    {
        return $this->render('about');
    }
        
    public function actionValidate() {
        $user = Utilisateur::getConnectedUser();        
        $params = Yii::$app->request->bodyParams;
//        $result = '';
        foreach ($params as $k => $v){
            
            $realisation = new \app\models\Realisation();
            
            if (strstr($k, 'exercice-id')){
                $realisation->exercice_id = $v;
                
            } else if (strstr($k, 'mesure-id-')){              
                $realisation->indicateur_id = $v;
                
            } else if (strstr($k, 'realise-')) {
                $realisation->realise = $v;
                
            } else if (strstr($k, 'prevue-')){
                $realisation->prevue = $v;
            }
            $realisation->utilisateur_id = $user->id;
            $realisation->etat = \app\models\Realisation::ETAT_VALID;
            
//            if ($realisation->save()){
//                $result .= 'id:'+$realisation->id.' saved.';
//            } else {
//                $result .= implode('-', $realisation->getErrorSummary(false));
//            }
        }

        return $this->createRealisation(1, 1, 80, 100, $user->id, Realisation::ETAT_VALID);
    }
    
    private function createRealisation($exercice_id, $indicateur_id, $realise, $prevue, $utilisateur_id, $etat) {
        $realisation = new \app\models\Realisation();
        $realisation->exercice_id = $exercice_id;
        $realisation->indicateur_id = $indicateur_id;
        $realisation->realise = $realise;
        $realisation->prevue = $prevue;
        $realisation->utilisateur_id = $utilisateur_id;
        $realisation->etat = $etat;
//        $result = '';
        if ($realisation->save(true /* runValidation = true*/)){
            $realisation->refresh(); // to get the id back from the db
            return $realisation;
//            $result .= 'id:'+$realisation->id.',';
        } else {
            return NULL;
//            $result .= implode('-', $realisation->getErrorSummary(true));
        }
//        var_dump($result);
    }
//function added to fill the indicateur of a certain exercice of a certain vancevas

    
}