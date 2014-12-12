<?php

use yii\helpers\Html;
use yii\web\ForbiddenHttpException;

/* @var $this yii\web\View */
/* @var $model app\models\User */

if($isAdmin){
	$this->title = 'Create User';
	$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
	$this->params['breadcrumbs'][] = $this->title;
	?>
	<div class="user-create">

	    <h1><?= Html::encode($this->title) ?></h1>

	    <?= $this->render('_form', [
	        'model' => $model,
	        'from' => 'create_user'
	    ]) ?>

	</div>
<?php } else throw new ForbiddenHttpException('You are not allowed to access this page.'); ?>