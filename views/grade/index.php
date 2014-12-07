<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;
use kartik\grid\EditableColumn;
use yii\bootstrap\BootstrapAsset;

/* @var $this yii\web\View */
/* @var $searchModel app\models\GradeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $from_req_page ? 'Grades for '.$req->title.'('.$req->perfect_grade.')' : 'Grades';

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="grade-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php  //echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Grade', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    
    <?php
        $grade_column = !$from_req_page ? 'grade' :
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
                'hAlign'=>'left', 
                'vAlign'=>'middle',
                'width'=>'200px',
                'format'=>['decimal', 2],
                'pageSummary' => true
            ];
        
        $gridColumns = [
            $grade_column,
            //'requirement_id',
            [
                'attribute' => 'requirement',
                /*'value' => function ($model) {
                    $val = $model->findRequirementDescription($model->requirement_id)->title;
                    return $val;
                },*/
                'value' => 'requirement.title',
                'enableSorting' => true
            ],
            'student_no',
            [
                'attribute' => 'student_name',
                'value' => function ($model) {
                    $val = $model->findStudentName($model->student_no);
                    return $val->lname.', '.$val->fname;
                },
                'enableSorting' => true
            ],
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
