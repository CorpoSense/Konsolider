<?php

namespace app\controllers;

use Yii;
use app\models\Realisation;
use app\models\RealisationSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use arogachev\excel\export\basic\Exporter;
use app\models\UploadForm;
use yii\web\UploadedFile;
use yii\filters\AccessControl;
use app\components\AccessRule;
use app\models\User;



/**
 * RealisationController implements the CRUD actions for Realisation model.
 */
class RealisationController extends Controller
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
                'only' => ['index','create', 'update', 'delete'],
                'rules' => [
                        [
                        'actions' => ['index','create'],
                        'allow' => true,
                        // Allow users and admins to create
                            'roles' => [
                                User::ROLE_ADMIN
                            ],
                        ],
                       [
                           'actions' => ['update'],
                           'allow' => true,
                           // Allow moderators and admins to update
                           'roles' => [
                               User::ROLE_ADMIN
                           ],
                       ],
                       [
                           'actions' => ['delete'],
                           'allow' => true,
                           // Allow admins to delete
                           'roles' => [
                               User::ROLE_ADMIN
                           ],
                       ],                    

                ]
            ]
        ];
    }

    /**
     * Lists all Realisation models.
     * @return mixed
     */
    public function actionIndex()
    {
        $modelUpload = new UploadForm();
        $searchModel = new RealisationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
             'modelUpload' => $modelUpload,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Realisation model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Realisation model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Realisation();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Realisation model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Realisation model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Realisation model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Realisation the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Realisation::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
    
    public function actionExport() {
        $file = Yii::getAlias('@app/RealisationExport.xlsx');
        $exporter = new Exporter([
            'query' => Realisation::find(),
            'filePath' => $file,
//            'dataProvider' => Realisation::className(),
            'sheetTitle' => 'Realisations',
            'standardModelsConfig' => [
                [
                    'className' => Realisation::className(),
                    'extendStandardAttributes' => false,
//                    'attributesOrder' => ['prevue', 'realise', 'etat'],
                    'standardAttributesConfig' => [
                        [
                            'name' => 'id',
                            'label' => 'ID'
                        ],
                        [
                            'name' => 'prevue',
                            'label' => 'Prevue'
                        ],
                        [
                            'name' => 'realise',
                            'label' => 'Realise'
                        ],
                        [
                            'name' => 'utilisateur_id',
                            'label' => 'Utilisateur',
                            'valueReplacement' => function ($model) {
                                return $model->utilisateur->nom;
                            },
                        ],
                        [
                            'name' => 'indicateur_id',
                            'label' => 'Indicateur',
                            'valueReplacement' => function ($model) {
                                return $model->indicateur->nom;
                            },
                        ],
                        [
                            'name' => 'etat',
                            'label' => 'Etat'
                        ],
                    ]
                ]
            ]
        ]);
        $exporter->run();
        if (file_exists($file)) {
            Yii::$app->response->sendFile($file);
        } else {
            Yii::$app->session->setFlash('warning', 'Erreur lors exportation des données');
            return $this->redirect(['index']);
        }
    }
}
