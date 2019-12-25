<?php

namespace app\controllers;

use Yii;
use app\models\Exercice;
use app\models\ExerciceSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use arogachev\excel\import\basic\Importer;
use yii\helpers\Html;
use app\models\UploadForm;
use yii\web\UploadedFile;
use arogachev\excel\export\basic\Exporter;



/**
 * ExerciceController implements the CRUD actions for Exercice model.
 */
class ExerciceController extends Controller
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
        ];
    }

    /**
     * Lists all Exercice models.
     * @return mixed
     */
    public function actionIndex()
    {
        
         $modelUpload = new UploadForm();
        $searchModel = new ExerciceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'modelUpload' => $modelUpload,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Exercice model.
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
     * Creates a new Exercice model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Exercice();

        if ($model->load(Yii::$app->request->post())) {

          try {
            if ($model->save()){
              return $this->redirect(['view', 'id' => $model->id]);
            }

          } catch (\Exception $e) {
            if ($e->getCode()===23000){ // duplicate key
                \Yii::$app->session->setFlash('warning', 'Erreur: Cet Exercice existe déjà');
            } else {
                \Yii::$app->session->setFlash('error', 'Erreur: '.$e->getMessage());
            }
          }
        }

        return $this->render('create', [
            'model' => $model,
            //'errors' => $model->getErrors()
        ]);
    }

    /**
     * Updates an existing Exercice model.
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
     * Deletes an existing Exercice model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        try {
            $this->findModel($id)->delete();
        } catch (\Exception $e) {
            if ($e->getCode()===23000){ // constraints key violation
                \Yii::$app->session->setFlash('warning', 'Impossible de supprimer les données de cet exercice, les réalisations ont été validées.');
            } else {
                \Yii::$app->session->setFlash('error', 'Erreur: '.$e->getMessage());
            }
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the Exercice model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Exercice the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Exercice::findOne($id)) !== null) {
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
                        'className' => Unite::className(),
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
        $file = Yii::getAlias('@app/ExerciceExport.xlsx');
        $exporter = new Exporter([
            'query' => Exercice::find(),
            'filePath' => $file,
//            'dataProvider' => Realisation::className(),
            'sheetTitle' => 'Realisations',
            'standardModelsConfig' => [
                [
                    'className' => Exercice::className(),
                    'extendStandardAttributes' => false,
//                    'attributesOrder' => ['prevue', 'realise', 'etat'],
                    'standardAttributesConfig' => [
                        [
                            'name' => 'id',
                            'label' => 'ID'
                        ],
                        [
                            'name' => 'canevas',
                            'label' => 'Canevas',
                            'valueReplacement' => function ($model) {
                                return $model->canevas->nom;
                            },
                        ],
                        [
                            'name' => 'rapport',
                            'label' => 'Rapport',
                            'valueReplacement' => function ($model) {
                                return $model->rapport->nom;
                            },
                        ],
                        [
                            'name' => 'unite',
                            'label' => 'Unite',
                            'valueReplacement' => function ($model) {
                                return $model->unite->nom;
                            },
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
