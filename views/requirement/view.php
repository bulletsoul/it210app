<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\web\ForbiddenHttpException;

/* @var $this yii\web\View */
/* @var $model app\models\Requirement */
if($isAdmin){
    $this->title = $model->title;
    $this->params['breadcrumbs'][] = ['label' => 'Requirements', 'url' => ['index']];
    $this->params['breadcrumbs'][] = $this->title;
    ?>
    <div class="requirement-view">

        <h1><?= Html::encode($this->title) ?></h1>

        <p>
            <?= Html::a('Update', ['update', 'id' => $model->requirement_id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Delete', ['delete', 'id' => $model->requirement_id], [
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
                // 'requirement_id',
                'description',
                'title',
                'category_id',
                'perfect_grade',
            ],
        ]) ?>

    </div>
<?php } else throw new ForbiddenHttpException('You are not allowed to access this page.'); ?>