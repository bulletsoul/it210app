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
	 public function actionUpattotal(){
				$teacher=User::find()
            ->where(['user_type'=>0])
            ->one();
		
				 if(isset($_GET['attValue'])){
				 	//setting the $connection variable to support the non sql commands
        	$connection = new \yii\db\Connection([
    				'dsn' => 'mysql:host=localhost;dbname=it210app',
    				'username' => 'root',
    				'password' => '',
					]);
						$connection->open();
						$newAttvalue=$_GET['attValue'];
						
				 		$connection->createCommand()->update('user', ['att_no' => $newAttvalue], 'user_type=0')->execute();
				 		return "mau".$newAttvalue;
				 		}
				 		
				return $this->render('upattotal', [
            'teacher' => $teacher,
        ]);
		}
	public function actionCheckatt(){$query = new Query;
        $query->select('lname, fname, att_no')
            ->from('user')
            ->where('user_type=1');
          // 	->OrderBy('lname');
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
							
    		$students=User::find()
            ->where(['user_type'=>1])
          //  ->orderBy('lname')
            ->all();
        
        $teacher=User::find()
            ->where(['user_type'=>0])
          //  ->orderBy('lname')
            ->one();
            
        if(isset($_GET['keylist'])){
        	//setting the $connection variable to support the non sql commands
        	$connection = new \yii\db\Connection([
    				'dsn' => 'mysql:host=localhost;dbname=it210app',
    				'username' => 'root',
    				'password' => '',
					]);
					$connection->open();
         
					$d=$_GET['keylist'];
        	$token = strtok($d, ",");
        	$ctr=0;
        	
        	foreach ($students as $student){        
        		$currAtt=	$student->att_no;
 	        	$studNum = $student->student_no;
        	  if($token==$ctr){
       	    		$cur=$currAtt + 1;
        	 		 	$connection->createCommand()->update('user', ['att_no' => $cur], ['student_no'=>$studNum])->execute();
        	  	$token = strtok(",");
        	  }
        		 
        		$ctr++; 
        	}        		
 
    		}
     		$query = new Query;
        $query->select('lname, fname, att_no')
            ->from('user')
            ->where('user_type=1');
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render('checkatt', [
            'dataProvider' => $dataProvider,
            'teacher' => $teacher,
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
