<?php

use yii\helpers\Html;
use yii\web\ForbiddenHttpException;

/* @var $this yii\web\View */
/* @var $model app\models\Grade */

if($isAdmin){
	$this->title = 'Update Grade: ' . ' ' . $model->requirement_id;
	$this->params['breadcrumbs'][] = ['label' => 'Grades', 'url' => ['index']];
	$this->params['breadcrumbs'][] = ['label' => $model->requirement_id, 'url' => ['view', 'requirement_id' => $model->requirement_id, 'student_no' => $model->student_no]];
	$this->params['breadcrumbs'][] = 'Update';
	?>
	<div class="grade-update">

	    <h1><?= Html::encode($this->title) ?></h1>

	    <?= $this->render('_form', [
	        'model' => $model,
	    ]) ?>

	</div>
<?php } else throw new ForbiddenHttpException('You are not allowed to access this page.'); ?>