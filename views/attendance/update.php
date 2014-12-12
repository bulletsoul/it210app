<?php

use yii\helpers\Html;
use yii\web\ForbiddenHttpException;

/* @var $this yii\web\View */
/* @var $model app\models\Attendance */

if(!$isGuest){
	$this->title = 'Update Attendance: ' . ' ' . $model->student_no;
	$this->params['breadcrumbs'][] = ['label' => 'Attendances', 'url' => ['index']];
	$this->params['breadcrumbs'][] = ['label' => $model->student_no, 'url' => ['view', 'student_no' => $model->student_no, 'date' => $model->date]];
	$this->params['breadcrumbs'][] = 'Update';
	?>
	<div class="attendance-update">

	    <h1><?= Html::encode($this->title) ?></h1>

	    <?= $this->render('_form', [
	        'model' => $model,
	    ]) ?>

	</div>
<?php } else throw new ForbiddenHttpException('You are not allowed to access this page.'); ?>