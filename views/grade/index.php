<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;
use kartik\grid\EditableColumn;
use yii\bootstrap\BootstrapAsset;

/* @var $this yii\web\View */
/* @var $searchModel app\models\GradeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $from_req_page ? 'Grades for '.$req : 'Grades';

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="grade-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php  //echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Grade', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    
    <?php
        $gridColumns = [
            // the buy_amount column configuration
            [
                'class' => 'kartik\grid\EditableColumn',
                'attribute'=>'grade', 
                'editableOptions' => [
                    'header' => 'Grade',
                    'inputType' => \kartik\editable\Editable::INPUT_SPIN,
                    'options' => [
                        'pluginOptions' => ['min'=>0, 'max'=>100]
                    ]
                ],
                //'hAlign'=>'left', 
                'vAlign'=>'middle',
                'width'=>'200px',
                'format'=>['decimal', 2],
                'pageSummary' => true
            ],
            //'requirement_id',
            [
                'attribute' => 'Requirement',
                'value' => function ($model) {
                    $val = $model->findRequirementDescription($model->requirement_id)->title;
                    return $val;
                }
            ],
            'student_no',
        ];
    // end of grid columns definition
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => $gridColumns/*[
            ['class' => 'yii\grid\SerialColumn'],

            'requirement_id',
            'student_no',
            'grade',

            ['class' => 'yii\grid\ActionColumn'],
        ],*/
    ]); ?>

</div>
