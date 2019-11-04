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
use app\models\Indicateur;
use app\models\Utilisateur;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
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

    /**
     * {@inheritdoc}
     */
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

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        // if (Yii::$app->user->isGuest) {
        //     return $this->redirect(['site/login']);
        // }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $exercices = [];
        if (isset(Yii::$app->user->identity)){
            if (Yii::$app->user->identity->isAdmin()){
                // role "admin"
                $exercices = Exercice::find()->orderBy('unite_id')->all();
            } else {
                // role "user"
                $user = Utilisateur::find()->where(['user_id'=> Yii::$app->user->id])->one();
                $exercices = Exercice::find()->where(['unite_id' => $user->unite->id])->all();
            }
        }
        return $this->render('index', [
            'model' => $model,
            'exercices' => $exercices,
        ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
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

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
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

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
        
    public function actionValidate() {
        $user = Utilisateur::find()->where( ['user_id' => Yii::$app->user->identity->id] )->one();        
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

        return $this->saveRealisation(1, 1, 80, 100, $user->id);
    }
    
    public function actionLog() {
        $this->render('@app/views/login/Log');
    }

    private function saveRealisation($exercice_id, $indicateur_id, $realise, $prevue, $utilisateur_id) {
        $realisation = new \app\models\Realisation();
        $realisation->exercice_id = $exercice_id;
        $realisation->indicateur_id = $indicateur_id;
        $realisation->realise = $realise;
        $realisation->prevue = $prevue;
        $realisation->utilisateur_id = $utilisateur_id;
        $realisation->etat = \app\models\Realisation::ETAT_VALID;
//        $result = '';
//        if ($realisation->save()){
//            $result .= 'id:'+$realisation->id.',';
//        } else {
//            $result .= implode('-', $realisation->getErrorSummary(true));
//        }
        return $realisation->save();
    }

    
}