<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Category;

/* @var $this yii\web\View */
/* @var $model app\models\Requirement */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="requirement-form">

    <?php $form = ActiveForm::begin(); ?>  
    
    <div class="form-group">        
    <label for="category">Category</label>
    <?= Html::activeDropDownList($model, 'category_id',
                ArrayHelper::map(Category::find()->all(), 'category_id', 'description'),
                ['id' => 'category', 'class' => 'form-control']) ?>
    </div>
    
    <?= $form->field($model, 'title')->textInput() ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => 800]) ?>   

    <?= $form->field($model, 'perfect_grade')->textInput(['maxlength' => 10]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
