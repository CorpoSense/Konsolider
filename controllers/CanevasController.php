<?php

namespace app\controllers;

use Yii;
use app\models\Canevas;
use app\models\CanevasSearch;
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


/**
 * CanevasController implements the CRUD actions for Canevas model.
 */
class CanevasController extends Controller
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
     * Lists all Canevas models.
     * @return mixed
     */
    public function actionIndex()
    {
        $modelUpload = new UploadForm();
        $searchModel = new CanevasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'modelUpload' => $modelUpload,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Canevas model.
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
     * Creates a new Canevas model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Canevas();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Canevas model.
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
     * Deletes an existing Canevas model.
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
     * Finds the Canevas model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Canevas the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Canevas::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
        public function actionImport() {
       $model = new UploadForm();
       
       if (Yii::$app->request->isPost) {
          $model->file = UploadedFile::getInstance($model, 'file');
          if ($model->upload()) {
             // file is uploaded successfully

            $file = $model->getFullPath(); //Yii::getAlias('@app/UnitesImport.xlsx');
            
            if (!isset($file) || $file == '') {
                Yii::$app->session->setFlash('warning', 'Fichier introuvable!');
                return $this->redirect(['index']);
            }
            $importer = new Importer([
                'filePath' => $file,
                'standardModelsConfig' => [
                    [
                        'className' => Canevas::className(),
                        'standardAttributesConfig' => [
                        ],
                    ],
                ],
            ]);
            if ($importer->run()) {
                Yii::$app->session->setFlash('success', 'Fichier importé avec succès.');
            } else {
                if ($importer->wrongModel) {
                    Yii::$app->session->setFlash('error', Html::errorSummary($importer->wrongModel));
                } else {
                    Yii::$app->session->setFlash('warning', $importer->error);
                }
            }
            // delete imported file.
            unlink($file);
          } else {
              Yii::$app->session->setFlash('error', 'Error while uploading a file.');
          }
       }
       
       return $this->redirect(['index']);
    }
     public function actionExport() {
        $file = Yii::getAlias('@app/CanevasExport.xlsx');
        $exporter = new Exporter([
            'query' => Canevas::find(),
            'filePath' => $file,
//            'dataProvider' => Realisation::className(),
            'sheetTitle' => 'Canevas',
            'standardModelsConfig' => [
                [
                    'className' => Canevas::className(),
                    'extendStandardAttributes' => false,
//                    'attributesOrder' => ['prevue', 'realise', 'etat'],
                    'standardAttributesConfig' => [
                        [
                            'name' => 'id',
                            'label' => 'ID'
                        ],
                        [
                            'name' => 'nom',
                            'label' => 'Nom'
                        ],
                        [
                            'name' => 'description',
                            'label' => 'Description',
                           
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
