<?php

use yii\helpers\Html;
use yii\web\ForbiddenHttpException;

/* @var $this yii\web\View */
/* @var $model app\models\Requirement */
if($isAdmin){
	$this->title = 'Create Requirement';
	$this->params['breadcrumbs'][] = ['label' => 'Requirements', 'url' => ['index']];
	$this->params['breadcrumbs'][] = $this->title;
	?>
	<div class="requirement-create">

	    <h1><?= Html::encode($this->title) ?></h1>

	    <?= $this->render('_form', [
	        'model' => $model,
	    ]) ?>

	</div>
<?php } else throw new ForbiddenHttpException('You are not allowed to access this page.'); ?>