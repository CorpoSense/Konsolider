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
        $unite_id = 0;
        $rapport_id = 0;
        $canevas_id = 0;
        
        $filterModel = new \app\models\FilterForm();
        
        // if user is loggedIn
        if (!Yii::$app->user->isGuest){
            
            if (Yii::$app->user->identity->isAdmin()){
                // role == "admin"
                $query = Exercice::find();
                if ($filterModel->load(Yii::$app->request->post()) && $filterModel->validate()){
                        $query->andFilterWhere(['unite_id' => $filterModel->unite_id])
                                ->andFilterWhere(['rapport_id' => $filterModel->rapport_id])
                                ->andFilterWhere(['canevas_id' => $filterModel->canevas_id]);
                }
                $exercices = $query->orderBy('unite_id')->all();
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
        } //if !isGuest()
        return $this->render('index', [
            'model' => $model,
            'exercices' => $exercices,
            'filterModel' => $filterModel
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