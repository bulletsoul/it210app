<?php

namespace app\controllers;

use Yii;
use app\models\Grade;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * GradeController implements the CRUD actions for Grade model.
 */
class GradeController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Grade models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Grade::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Grade model.
     * @param integer $requirement_id
     * @param string $student_no
     * @return mixed
     */
    public function actionView($requirement_id, $student_no)
    {
        return $this->render('view', [
            'model' => $this->findModel($requirement_id, $student_no),
        ]);
    }

    /**
     * Creates a new Grade model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Grade();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'requirement_id' => $model->requirement_id, 'student_no' => $model->student_no]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Grade model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $requirement_id
     * @param string $student_no
     * @return mixed
     */
    public function actionUpdate($requirement_id, $student_no)
    {
        $model = $this->findModel($requirement_id, $student_no);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'requirement_id' => $model->requirement_id, 'student_no' => $model->student_no]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Grade model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $requirement_id
     * @param string $student_no
     * @return mixed
     */
    public function actionDelete($requirement_id, $student_no)
    {
        $this->findModel($requirement_id, $student_no)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Grade model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $requirement_id
     * @param string $student_no
     * @return Grade the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($requirement_id, $student_no)
    {
        if (($model = Grade::findOne(['requirement_id' => $requirement_id, 'student_no' => $student_no])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
