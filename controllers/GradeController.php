<?php

namespace app\controllers;

use Yii;
use app\models\Grade;
use app\models\GradeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;

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
        // Variables
        $model = new Grade();
        $searchModel = new GradeSearch();
        $from_req_page = false;
        $req = '';      
        $isGuest = Yii::$app->user->isGuest;
        $isAdmin = ((!$isGuest)&&(Yii::$app->user->identity->user_type == 0));
        $query = '';               
        
        // Get request parameters        
        $qryParams = Yii::$app->request->queryParams;

        if(!$isGuest) {
                
                // Check parameters if request came from requirements page
                // There are two parameters if from req'ts page, otherwise, just 1
                if(count($qryParams) > 1 && array_key_exists('id', $qryParams)){
                    $query = $isAdmin ?
                        $searchModel->search(['GradeSearch' => ['requirement_id' => $qryParams['id']]]) :
                        $searchModel->search(['GradeSearch' => ['requirement_id' => $qryParams['id'], 'student_no' => Yii::$app->User->identity->student_no]]);
                    $req = $model->findRequirement($qryParams['id']);
                    $from_req_page = true;   
                } else {
                    $query = $isAdmin ? $searchModel->search($qryParams) :
                        $searchModel->search(['GradeSearch' => ['student_no' => Yii::$app->User->identity->student_no]]);;
                }

        }

        $dataProvider = $query;
        
        // validate if there is a editable input saved via AJAX
        if (Yii::$app->request->post('hasEditable')) {
            // Create PHP value from stored representation of 'editableKey' 
            $keys = unserialize(Yii::$app->request->post('editableKey'));
            // Return model record with the requirement_id and student_no of the row being edited
            $model = $this->findModel($keys['requirement_id'], $keys['student_no']);
            
            // store a default json response as desired by editable
            $out = Json::encode(['output'=>'', 'message'=>'']);
            
            // fetch the first entry in posted data (there should 
            // only be one entry anyway in this array for an 
            // editable submission)
            // - $posted is the posted data for Book without any indexes
            // - $post is the converted array for single model validation
            $post = [];
            $posted = current($_POST['Grade']);
     
            // 
            if ($model->requirement_id) {
                $model->grade = $posted['grade'];
                // can save model or do something before saving model
                $model->save();
     
                // custom output to return to be displayed as the editable grid cell
                // data. Normally this is empty - whereby whatever value is edited by 
                // in the input by user is updated automatically.
                $output = '';
     
                // specific use case where you need to validate a specific
                // editable column posted when you have more than one 
                // EditableColumn in the grid view. We evaluate here a 
                // check to see if grade was posted for the Grade model
                if (isset($posted['grade'])) {
                   $output =  Yii::$app->formatter->asDecimal($model->grade, 2);
                }
                
                $out = Json::encode(['output'=>$output, 'message'=>'']);
            }
            // return ajax json encoded response and exit
            echo $out;
            return;
        }

        return $this->render('index', [
            'isGuest' => $isGuest,
            'isAdmin' => $isAdmin,            
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'from_req_page' => $from_req_page,
            'req' => $req,
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

        $isGuest = Yii::$app->user->isGuest;
        $isAdmin = ((!$isGuest)&&(Yii::$app->user->identity->user_type == 0));

        return $this->render('view', [
            'model' => $this->findModel($requirement_id, $student_no),
            'isGuest' => $isGuest,
            'isAdmin' => $isAdmin,  
        ]);
    }

    /**
     * Creates a new Grade model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

        $isGuest = Yii::$app->user->isGuest;
        $isAdmin = ((!$isGuest)&&(Yii::$app->user->identity->user_type == 0));

        $model = new Grade();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'requirement_id' => $model->requirement_id, 'student_no' => $model->student_no]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'isGuest' => $isGuest,
                'isAdmin' => $isAdmin,  
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

        $isGuest = Yii::$app->user->isGuest;
        $isAdmin = ((!$isGuest)&&(Yii::$app->user->identity->user_type == 0));

        $model = $this->findModel($requirement_id, $student_no);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'requirement_id' => $model->requirement_id, 'student_no' => $model->student_no]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'isGuest' => $isGuest,
                'isAdmin' => $isAdmin,                  
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

        $isGuest = Yii::$app->user->isGuest;
        $isAdmin = ((!$isGuest)&&(Yii::$app->user->identity->user_type == 0));

        $this->findModel($requirement_id, $student_no)->delete();

        return $this->redirect('index', [
            'isGuest' => $isGuest,
            'isAdmin' => $isAdmin,   
        ]);
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
