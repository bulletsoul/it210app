<?php

use yii\helpers\Html;
use yii\web\ForbiddenHttpException;

/* @var $this yii\web\View */
/* @var $model app\models\User */

if(!$isGuest){
    $this->title = 'Update User: ' . ' ' . $model->user_id;
    $this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
    $this->params['breadcrumbs'][] = ['label' => $model->student_no, 'url' => ['view', 'id' => $model->user_id]];
    $this->params['breadcrumbs'][] = 'Update';
?>
    <div class="user-update">
    
        <h1><?= Html::encode($this->title) ?></h1>
    
        <?= $this->render('_form', [
            'model' => $model,
            'from' => 'update_user'
        ]) ?>
    
    </div>
<?php } else throw new ForbiddenHttpException('You are not allowed to access this page.'); ?>
