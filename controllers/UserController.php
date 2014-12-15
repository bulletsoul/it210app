<?php

namespace app\controllers;

use Yii;
use app\models\User;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Query;
use yii\db\QueryBuilder;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
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
     * Lists all User models.
     * @return mixed
     */
	 
	public function actionCheckatt(){
	
		$query = new Query;
        $query->select('lname, fname, att_no')
            ->from('user')
            ->where('user_type=1');
          // 	->OrderBy('lname');
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
			$queryBuilder= new QueryBuilder($query);
			//	$params = [];
			//	$sql = $queryBuilder->update('user', ['att_no' => 1], 'user_id = 10', $params);
							
    		$students=User::find()
            ->where(['user_type'=>1])
          //  ->orderBy('lname')
            ->all();
            
        if(isset($_GET['keylist'])){
        	$d=$_GET['keylist'];
        	$token = strtok($d, ",");
        	$ctr=0;
        	
        	foreach ($students as $student){        
        		
        	  if($token==$ctr){
        	  	//$student->att_no=5;
        	  	//$students->save();
        	  	$token = strtok(",");
        	  }
        		echo $student->att_no;
        		$ctr++; 
        	}
        return "Data updated";
    }
	else{
		error_log('here...');
        return $this->render('checkatt', [
            'dataProvider' => $dataProvider,
        ]);   
    }
	}
    public function actionIndex()
    {
        $isGuest = Yii::$app->user->isGuest;
        $isAdmin = ((!$isGuest)&&(Yii::$app->user->identity->user_type == 0));
        $query = '';
        
        if(!$isGuest){
            $query = $isAdmin ?
                User::find()://->where(['user_type' => 1]) :
                User::find()->where(['user_id' => Yii::$app->User->identity->user_id]);
        }        
        
        // Return students only
        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'isGuest' => $isGuest,
            'isAdmin' => $isAdmin
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {

        $isGuest = Yii::$app->user->isGuest;
        $isAdmin = ((!$isGuest)&&(Yii::$app->user->identity->user_type == 0));

        return $this->render('view', [
            'model' => $this->findModel($id),
            'isGuest' => $isGuest,
            'isAdmin' => $isAdmin
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $isGuest = Yii::$app->user->isGuest;
        $isAdmin = ((!$isGuest)&&(Yii::$app->user->identity->user_type == 0));

        $success = false;
        
        $model = new User();
        
        if ($model->load(Yii::$app->request->post())){            
            
            $model->password = md5($model->password);
        
            if($model->save()){
                $success = true;
            }
        }   
        
        if($success){
            return $this->redirect(['index']);
        } else {            
            return $this->render('create', [
                'model' => $model,
                'isGuest' => $isGuest,
                'isAdmin' => $isAdmin
            ]);
        }
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $isGuest = Yii::$app->user->isGuest;
        $isAdmin = ((!$isGuest)&&(Yii::$app->user->identity->user_type == 0));

        $success = false;
        
        $model = $this->findModel($id); 
        
        $oldPassword = $model->password;
        
        if ($model->load(Yii::$app->request->post())){            
            
            if($model->password!=$oldPassword){
                $model->password = md5($model->password);
            }
        
            if($model->save()){
                $success = true;
            }
        }   
        
        if($success){
            return $this->redirect(['view', 'student_no' => $model->student_no]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'isGuest' => $isGuest,
                'isAdmin' => $isAdmin
            ]);
        }   
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {

        $isGuest = Yii::$app->user->isGuest;
        $isAdmin = ((!$isGuest)&&(Yii::$app->user->identity->user_type == 0));

        $this->findModel($id)->delete();

        return $this->redirect('index', [
            'isGuest' => $isGuest,
            'isAdmin' => $isAdmin
        ]);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
