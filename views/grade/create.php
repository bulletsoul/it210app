<?php

use yii\helpers\Html;
use yii\web\ForbiddenHttpException;

/* @var $this yii\web\View */
/* @var $model app\models\Grade */

if($isAdmin){
	$this->title = 'Create Grade';
	$this->params['breadcrumbs'][] = ['label' => 'Grades', 'url' => ['index']];
	$this->params['breadcrumbs'][] = $this->title;
	?>
	<div class="grade-create">

	    <h1><?= Html::encode($this->title) ?></h1>

	    <?= $this->render('_form', [
	        'model' => $model,
	    ]) ?>

	</div>
<?php } else throw new ForbiddenHttpException('You are not allowed to access this page.'); ?>