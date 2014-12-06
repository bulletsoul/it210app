<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Grade */

$this->title = $model->requirement_id;
$this->params['breadcrumbs'][] = ['label' => 'Grades', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="grade-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'requirement_id' => $model->requirement_id, 'student_no' => $model->student_no], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'requirement_id' => $model->requirement_id, 'student_no' => $model->student_no], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'requirement_id',
            'student_no',
            'grade',
        ],
    ]) ?>

</div>
