<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\web\ForbiddenHttpException;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
if(!$isGuest){
    $this->title = 'Attendances';
    $this->params['breadcrumbs'][] = $this->title;
    ?>
    <div class="attendance-index">

        <h1><?= Html::encode($this->title) ?></h1>

        <p>
            <?= Html::a('Create Attendance', ['create'], ['class' => 'btn btn-success']) ?>
        </p>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'student_no',
                'date',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>

    </div>
<?php } else throw new ForbiddenHttpException('You are not allowed to access this page.'); ?>
