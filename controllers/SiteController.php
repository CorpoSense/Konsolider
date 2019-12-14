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
use app\models\Canevas;
use app\models\Realisation;
use app\models\Indicateur;
use app\models\Utilisateur;
use app\models\ExerciceSearch;
use yii\helpers\ArrayHelper;

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

        $searchModel = new ExerciceSearch();
         $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $canevas = Canevas::find()->all();
       $canevas = ArrayHelper::map($canevas,'id','nom');
       $unite = Unite::find()->all();
       $unite = ArrayHelper::map($unite,'id','nom');

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
                                'canevas' => $canevas,
                                'dataProvider' => $dataProvider,
                                'unite' => $unite,
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
                    'realisations' => $realisations,
                    'searchModel' => $searchModel,
                     'canevas' => $canevas,
                      'dataProvider' => $dataProvider,
                      'unite' => $unite,
                ]);
                
            }
        }
        return $this->render('index', [
            'model' => $model,
            'exercices' => $exercices,
            'searchModel' => $searchModel,
            'canevas' => $canevas,
            'dataProvider' => $dataProvider,
            'unite' => $unite,
        ]);
    }
      public function actionTri($id){
        $exercices = Exercice::find()->orderBy('unite_id')->all();
         return $this->render('index', ['exercices' =>[],'amar'=>1]);

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
        $result = '';
        $data = [];
        foreach ($params as $k => $v){
            if (strstr($k, 'realisation-id-')){
                $data['id'] = $v;
            } else if (strstr($k, 'realise-')) {
                $data['realise'] = $v;
            } else if (strstr($k, 'prevue-')){
                $data['prevue']= $v;
            }
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
        Yii::$app->session->setFlash('success', $result);
        return $this->redirect(['site/index']);
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