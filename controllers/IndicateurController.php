<?php

namespace app\controllers;

use Yii;
use app\models\Indicateur;
use app\models\IndicateurSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use arogachev\excel\import\basic\Importer;
use yii\helpers\Html;
use app\models\UploadForm;
use yii\web\UploadedFile;
use arogachev\excel\export\basic\Exporter;

/**
 * IndicateurController implements the CRUD actions for Indicateur model.
 */
class IndicateurController extends Controller
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
     * Lists all Indicateur models.
     * @return mixed
     */
    public function actionIndex()
    {

         $modelUpload = new UploadForm();
        $searchModel = new IndicateurSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'modelUpload' => $modelUpload,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Indicateur model.
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
     * Creates a new Indicateur model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Indicateur();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Indicateur model.
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
     * Deletes an existing Indicateur model.
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
     * Finds the Indicateur model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Indicateur the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Indicateur::findOne($id)) !== null) {
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
        $file = Yii::getAlias('@app/IndicateurExport.xlsx');
        $exporter = new Exporter([
            'query' => Indicateur::find(),
            'filePath' => $file,
//            'dataProvider' => Realisation::className(),
            'sheetTitle' => 'Realisations',
            'standardModelsConfig' => [
                [
                    'className' => Indicateur::className(),
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
                            'label' => 'Description'
                        ],
                        [
                            'name' => 'type',
                            'label' => 'Type',
                          
                        ],
                         [
                            'name' => 'unite_mesure',
                            'label' => 'Unite mesure',
                          
                        ],
                        [
                            'name' => 'requis',
                            'label' => 'Requis',
                          
                        ],
                         [
                            'name' => 'canvevas_id',
                            'label' => 'Canevas_id',
                          
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
