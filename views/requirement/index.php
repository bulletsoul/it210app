<?php

use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
//use yii\grid\GridView;
use yii\web\ForbiddenHttpException;
use app\models\Category;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
if(!$isGuest || $isAdmin){
    $this->title = 'Requirements';
    $this->params['breadcrumbs'][] = $this->title;
?>
    <div class="requirement-index">
    
        <h1><?= Html::encode($this->title) ?></h1>
    
        <p>
            <?= Html::a('Create Requirement', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
    
       
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
    
                //'requirement_id',
                'title',
                'description',
                //'category_id',
                [
                 'attribute' => 'category',
                 'value' => function ($model) {
                    $val = $model->findCategory($model->category_id)->description;
                    return $val;
                 },
                 'enableSorting' => true
                ],
                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    
    </div>
<?php } else throw new ForbiddenHttpException('You are not allowed to access this page.'); ?>
