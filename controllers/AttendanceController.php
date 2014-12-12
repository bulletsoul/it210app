<?php

namespace app\controllers;

use Yii;
use app\models\Attendance;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AttendanceController implements the CRUD actions for Attendance model.
 */
class AttendanceController extends Controller
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
     * Lists all Attendance models.
     * @return mixed
     */
    public function actionIndex()
    {

        $isGuest = Yii::$app->user->isGuest;
        $isAdmin = ((!$isGuest)&&(Yii::$app->user->identity->user_type == 0));

        $dataProvider = new ActiveDataProvider([
            'query' => Attendance::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'isGuest' => $isGuest,
            'isAdmin' => $isAdmin
        ]);
    }

    /**
     * Displays a single Attendance model.
     * @param string $student_no
     * @param string $date
     * @return mixed
     */
    public function actionView($student_no, $date)
    {

        $isGuest = Yii::$app->user->isGuest;
        $isAdmin = ((!$isGuest)&&(Yii::$app->user->identity->user_type == 0));

        return $this->render('view', [
            'model' => $this->findModel($student_no, $date),
            'isGuest' => $isGuest,
            'isAdmin' => $isAdmin
        ]);
    }

    /**
     * Creates a new Attendance model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

        $isGuest = Yii::$app->user->isGuest;
        $isAdmin = ((!$isGuest)&&(Yii::$app->user->identity->user_type == 0));

        $model = new Attendance();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'student_no' => $model->student_no, 'date' => $model->date]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'isGuest' => $isGuest,
                'isAdmin' => $isAdmin
            ]);
        }
    }

    /**
     * Updates an existing Attendance model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $student_no
     * @param string $date
     * @return mixed
     */
    public function actionUpdate($student_no, $date)
    {

        $isGuest = Yii::$app->user->isGuest;
        $isAdmin = ((!$isGuest)&&(Yii::$app->user->identity->user_type == 0));

        $model = $this->findModel($student_no, $date);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'student_no' => $model->student_no, 'date' => $model->date]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'isGuest' => $isGuest,
                'isAdmin' => $isAdmin
            ]);
        }
    }

    /**
     * Deletes an existing Attendance model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $student_no
     * @param string $date
     * @return mixed
     */
    public function actionDelete($student_no, $date)
    {
        $isGuest = Yii::$app->user->isGuest;
        $isAdmin = ((!$isGuest)&&(Yii::$app->user->identity->user_type == 0));

        $this->findModel($student_no, $date)->delete();

        return $this->redirect('index', [
            'isGuest' => $isGuest,
            'isAdmin' => $isAdmin
        ]);
    }

    /**
     * Finds the Attendance model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $student_no
     * @param string $date
     * @return Attendance the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($student_no, $date)
    {
        if (($model = Attendance::findOne(['student_no' => $student_no, 'date' => $date])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
