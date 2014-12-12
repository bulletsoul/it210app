<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\web\ForbiddenHttpException;

/* @var $this yii\web\View */
/* @var $model app\models\Category */
if($isAdmin){
	$this->title = 'Create Category';
	$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['index']];
	$this->params['breadcrumbs'][] = $this->title;
	?>
	<div class="category-create">

	    <h1><?= Html::encode($this->title) ?></h1>

	    <?= $this->render('_form', [
	        'model' => $model,
	    ]) ?>

	</div>
<?php } else throw new ForbiddenHttpException('You are not allowed to access this page.'); ?>
