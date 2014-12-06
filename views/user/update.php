<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$isGuest = Yii::$app->User->isGuest;
$isAdmin = ((!$isGuest)&&(Yii::$app->User->identity->user_type == 0));

if(!$isGuest || $isAdmin){
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
