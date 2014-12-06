<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\base\BootstrapInterface;
use yii\web\ForbiddenHttpException;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
if(!$isGuest || $isAdmin){
    $this->title = 'Users';
    $this->params['breadcrumbs'][] = $this->title;
    ?>
    <div class="user-index">
    
        <h1><?= Html::encode($this->title) ?></h1>
        
        <?php if($isAdmin){ ?>
            <p>
                <?= Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?>
            </p>
        <?php }  ?>
    
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
    
                //'user_type',
                'student_no',
                //'username',
                //'password',
                'lname',
                'fname',
                // 'user_id',
    
                ['class' => 'yii\grid\ActionColumn',
                 'buttons' => [                
                    'delete' => function ($url, $model, $key) {
                        // Have to redeclare for local scope
                        $isGuest = Yii::$app->User->isGuest;
                        $isAdmin = ((!$isGuest)&&(Yii::$app->User->identity->user_type == 0));
                        
                        return $isAdmin ? Html::a('<span class="glyphicon glyphicon-trash"></span>', $url) : '';
                    }
                 ], 
                ],
            ],
        ]); ?>
        </div>
                    
<?php } else throw new ForbiddenHttpException('You are not allowed to access this page.'); ?>
        


