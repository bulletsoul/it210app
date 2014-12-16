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
    
        <?php if ($isAdmin) {?>
        <p>
            <?= Html::a('Create Requirement', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
        <?php }; ?>
       
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
    
                //'requirement_id',
                //'title',
                [
                 'attribute' => 'title',
                 'format' => 'raw',
                 'value' => function ($model, $key, $index) { 
                    return Html::a($model->title, ['/grade/index', 'id' => $model->requirement_id]);
                 },
                ],
                'description',
                //'category_id',
                [
                 'attribute' => 'category',
                 'value' => function ($model) {
                    $val = $model->findCategory($model->category_id)->description;
                    return $val;
                 }
                ],
                // [
                //  'attribute' => 'perfect_grade',
                //  'value' => function ($model) {
                //     $val = $model->findRequirement($model->perfect_grade)->description;
                //     return $val;
                //  }
                // ],
                'perfect_grade',
                [
                // if ($isAdmin) 
                    'class' => 'yii\grid\ActionColumn',
					'visible' => $isAdmin
                ],
            ],
        ]); ?>
    
    </div>
<?php } else throw new ForbiddenHttpException('You are not allowed to access this page.'); ?>
