<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\web\ForbiddenHttpException;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
if(!$isGuest || $isAdmin){
    $this->title = 'Categories';
    $this->params['breadcrumbs'][] = $this->title;
?>
    <div class="category-index">
    
        <h1><?= Html::encode($this->title) ?></h1>
    
        <?php if($isAdmin){ ?>
            <p>
                <?= Html::a('Create Category', ['create'], ['class' => 'btn btn-success']) ?>
            </p>
        <?php } ?>
    
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
    
                //'category_id',
                'description',
                'percentage',
    
                ['class' => 'yii\grid\ActionColumn',
                 'visible' => $isAdmin],
            ],
        ]); ?>
    
    </div>
<?php } else throw new ForbiddenHttpException('You are not allowed to access this page.'); ?>