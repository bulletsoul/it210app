<?php

use yii\helpers\Html;
use yii\web\ForbiddenHttpException;

/* @var $this yii\web\View */
/* @var $model app\models\Requirement */
if($isAdmin){
	$this->title = 'Update Requirement: ' . ' ' . $model->title;
	$this->params['breadcrumbs'][] = ['label' => 'Requirements', 'url' => ['index']];
	$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->requirement_id]];
	$this->params['breadcrumbs'][] = 'Update';
	?>
	<div class="requirement-update">

	    <h1><?= Html::encode($this->title) ?></h1>

	    <?= $this->render('_form', [
	        'model' => $model,
	    ]) ?>

	</div>
<?php } else throw new ForbiddenHttpException('You are not allowed to access this page.'); ?>