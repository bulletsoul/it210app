<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\web\ForbiddenHttpException;

/* @var $this yii\web\View */
/* @var $model app\models\Category */
if($isAdmin){
	$this->title = 'Update Category: ' . ' ' . $model->category_id;
	$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['index']];
	$this->params['breadcrumbs'][] = ['label' => $model->category_id, 'url' => ['view', 'id' => $model->category_id]];
	$this->params['breadcrumbs'][] = 'Update';
	?>
	<div class="category-update">

	    <h1><?= Html::encode($this->title) ?></h1>

	    <?= $this->render('_form', [
	        'model' => $model,
	    ]) ?>

	</div>
<?php } else throw new ForbiddenHttpException('You are not allowed to access this page.'); ?>