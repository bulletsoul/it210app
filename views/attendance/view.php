<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\web\ForbiddenHttpException;

/* @var $this yii\web\View */
/* @var $model app\models\Attendance */

if(!$isGuest){
    $this->title = $model->student_no;
    $this->params['breadcrumbs'][] = ['label' => 'Attendances', 'url' => ['index']];
    $this->params['breadcrumbs'][] = $this->title;
    ?>
    <div class="attendance-view">

        <h1><?= Html::encode($this->title) ?></h1>

        <p>
            <?= Html::a('Update', ['update', 'student_no' => $model->student_no, 'date' => $model->date], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Delete', ['delete', 'student_no' => $model->student_no, 'date' => $model->date], [
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
                'student_no',
                'date',
            ],
        ]) ?>

    </div>
<?php } else throw new ForbiddenHttpException('You are not allowed to access this page.'); ?>