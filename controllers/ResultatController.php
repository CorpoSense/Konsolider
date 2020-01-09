<?php

namespace app\controllers;

use Yii;
use app\models\Rapport;
use app\models\Canevas;
use app\models\RapportSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use arogachev\excel\import\basic\Importer;
use yii\helpers\Html;
use app\models\UploadForm;
use yii\web\UploadedFile;
use arogachev\excel\export\basic\Exporter;
use yii\filters\AccessControl;
use app\components\AccessRule;
use app\models\User;
use yii\data\ActiveDataProvider;
use app\models\Realisation;
use app\models\RealisationSearch;


/**
 * RapportController implements the CRUD actions for Rapport model.
 */
class ResultatController extends Controller
{
    /**
     * {@inheritdoc}
     */
public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
             'access' => [
                'class' => AccessControl::className(),
                   // We will override the default rule config with the new AccessRule class
                   'ruleConfig' => [
                       'class' => AccessRule::className(),
                   ],
                'only' => ['index'],
                'rules' => [
                        [
                        'actions' => ['index'],
                        'allow' => true,
                        // Allow users and admins to create
                            'roles' => [
                                User::ROLE_ADMIN
                            ],
                        ],                 

                ]
            ]
        ];
    }

    public function actionIndex()
    {
//        if (isset(Yii::$app->request->post()['FilterConsolide']['rapport_id'])){
//            var_dump((int) Yii::$app->request->post()['FilterConsolide']['rapport_id']);
//            die('');
//        }
                
        if (Canevas::find()->count() == 0){
            Yii::$app->session->setFlash('warning', 'Vous devez créer au moins un Canevas');
            return $this->redirect(['canevas/create']);
        }
        if (Rapport::find()->count() == 0){
            Yii::$app->session->setFlash('warning', 'Vous devez créer au moins un Rapport');
            return $this->redirect(['rapport/create']);
        }
        
        $canevas_id = isset(Yii::$app->request->queryParams['canevas_id'])?
                ((int) Yii::$app->request->queryParams['canevas_id']): (Canevas::find()->limit(1)->one()->id);
        $rapportId = isset(Yii::$app->request->post()['FilterConsolide']['rapport_id'])?
                ((int) Yii::$app->request->post()['FilterConsolide']['rapport_id']): (Rapport::find()->limit(1)->one()->id);
        
        $query = Realisation::find()->select(
                ['indicateur_id', 'sum(prevue) as prevue', 'sum(realise) as realise'])
                ->from('realisation')
                ->where([
                    'canevas_id' => $canevas_id,
//                    'rapport_id' => $rapportId,
//                    'exercice_id' => 39,
                    'etat' => 1
                    ])                
                ->join('JOIN', 'indicateur', 'realisation.indicateur_id=indicateur.id')
                ->join('JOIN', 'utilisateur', 'realisation.utilisateur_id=utilisateur.id')
                ->join('JOIN', 'exercice', 'realisation.exercice_id=exercice.id')
                ->groupBy(['indicateur_id', 'exercice.canevas_id']);
        
        $filterModel = new \app\models\FilterConsolide();
//        if (!isset($filterModel->rapport_id)){
            $filterModel->rapport_id = $rapportId;
//        }
        if ($filterModel->load(Yii::$app->request->post()) && $filterModel->validate()){
            $query->andFilterWhere(['rapport_id' => $filterModel->rapport_id])
                    ->andFilterWhere(['canevas_id' => $filterModel->canevas_id]);
        }

//        $searchModel = new RealisationSearch();
//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
        ]);
        
        $exercices = \app\models\Exercice::find()->all();
        $rapports = [];
        $canevas = [];
        foreach ($exercices as $exercice){
            $rapport = $exercice->rapport;
            if (!key_exists($rapport->id, $rapports)){
                $rapports[$rapport->id] = $rapport->nom;
            }
            $caneva = $exercice->canevas;
            if (!key_exists($caneva->id, $canevas)){
                $canevas[$caneva->id] = $caneva->nom;
            }
        }        
        
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'filterModel' => $filterModel,
            'rapports' => $rapports,
            'canevas' => $canevas,
            'canevaId' => $canevas_id
        ]);
    }
    
}
