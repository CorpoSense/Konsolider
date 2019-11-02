<?php

namespace app\controllers;

use Yii;
use app\models\Exercice;
use app\models\ExerciceSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

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
        $searchModel = new ExerciceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
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
                \Yii::$app->session->setFlash('error', 'Erreur: Cet Exercice existe déjà');
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
            if ($e->getCode()===23000){ // duplicate key
                \Yii::$app->session->setFlash('warning', 'Impossible de supprimer les données de cet exercice, les réalisations ont été validées.');
            } else {
                \Yii::$app->session->setFlash('warning', 'Erreur: '.$e->getMessage());
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
}
