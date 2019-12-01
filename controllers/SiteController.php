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

class SiteController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
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

    public function actionIndex()
    {
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        $exercices = [];
        // if user is loggedIn
        if (!Yii::$app->user->isGuest){
            if (Yii::$app->user->identity->isAdmin()){
                // role == "admin"
                $exercices = Exercice::find()->orderBy('unite_id')->all();
            } else {
                // role == "user"
                $user = Utilisateur::getConnectedUser();
                // make sure the user is logged in and exists in the db
                if (!$user){
                    throw new \yii\web\ForbiddenHttpException('Access non autorisé!');
                }
                $exercices = Exercice::find()->where(['unite_id' => $user->unite->id])->all();
                $realisations = [];
                if (!empty($exercices)){
                    foreach ($exercices as $exercice) {
                        // add only the realisations needed from the $indicateurs list
                        $indicateurs = $exercice->canevas->indicateurs;
                        foreach ($indicateurs as $indicateur) {
                            $realisation = Realisation::find()->where([
                                'exercice_id' => $exercice->id,
                                'utilisateur_id' => $user->id,
                                'indicateur_id' => $indicateur->id,
                            ])->one();
                            // for each $exercice check if a realisation hasn't been created yet
                            if (empty($realisation)){
                                $realisation = $this->createRealisation(
                                        $exercice->id, 
                                        $indicateur->id, 
                                        0.0, //réalisé
                                        0.0, //prévue
                                        $user->id, 
                                        Realisation::ETAT_NONVALID);
                            } //if empty($realisation)
                            array_push($realisations, $realisation);
                        } //foreach $indicateurs
                    } //foreach $exercices
                } //if !empty($exercices)
                return $this->render('index', [
                    'model' => $model,
                    'exercices' => $exercices,
                    'realisations' => $realisations
                ]);
                
            }
        }
        return $this->render('index', [
            'model' => $model,
            'exercices' => $exercices,
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
    
    public function actionConfirm() {
        $user = Utilisateur::getConnectedUser();
        $params = Yii::$app->request->bodyParams;
        /*echo '<pre>';
        var_dump($params);
array(4) {
  ["_csrf"]=>
  string(88) "vmgelDwaxtFa5hkm3MEkelFBleZCThr3m0G-aVibN-nzAybEeC7_lzSufmnrs3U2ATXQ0yp5Xr7vEscgKPVRmQ=="
  ["realisation-id-31"]=>
  string(2) "31"
  ["prevue-1"]=>
  string(3) "200"
  ["realise-1"]=>
  string(2) "90"
}
        echo '</pre>';
        die('');*/
        $result = '';
        $data = [];
        foreach ($params as $k => $v){
//            $data = new Realisation();
            if (strstr($k, 'realisation-id-')){
                $data['id'] = $v;
//            } else if (strstr($k, 'exercice-id-')){              
//                $data['exercice_id'] = $v;
//            } else if (strstr($k, 'mesure-id-')){              
//                $data['indicateur_id'] = $v;
            } else if (strstr($k, 'realise-')) {
                $data['realise'] = $v;
            } else if (strstr($k, 'prevue-')){
                $data['prevue']= $v;
            }
//            $realisation['utilisateur_id'] = $user->id;
//            $realisation['etat'] = Realisation::ETAT_NONVALID; // ETAT_VALID; temporary
        }
        $realisation = Realisation::findOne( $data['id'] );
        $realisation->prevue = $data['prevue'];
        $realisation->realise = $data['realise'];
        $realisation->utilisateur_id = $user->id;
        $realisation->etat = Realisation::ETAT_VALID;
        if ($realisation->save()){
            $result .= $realisation->indicateur->nom.' a été enregistré.';
        } else {
            $result .= implode('-', $realisation->getErrorSummary(false));
        }
//        echo '<pre>';
//        var_dump($realisation);
//        echo '</pre>';
//        die('');
        Yii::$app->session->setFlash('success', $result);
        return $this->redirect(['site/index']);
    }
        
    /*public function actionValidate() {
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
    }*/
    
    private function createRealisation($exercice_id, $indicateur_id, $realise, $prevue, $utilisateur_id, $etat) {
        $realisation = new \app\models\Realisation();
        $realisation->exercice_id = $exercice_id;
        $realisation->indicateur_id = $indicateur_id;
        $realisation->realise = $realise;
        $realisation->prevue = $prevue;
        $realisation->utilisateur_id = $utilisateur_id;
        $realisation->etat = $etat;
//        $result = '';
        if ($realisation->save(true /*, runValidation = true*/)){
            $realisation->refresh(); // to get the id back from the db
            return $realisation;
//            $result .= 'id:'+$realisation->id.',';
        } else {
            return NULL;
//            $result .= implode('-', $realisation->getErrorSummary(true));
        }
//        var_dump($result);
    }

    
}