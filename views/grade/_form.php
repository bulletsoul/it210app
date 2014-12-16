<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Requirement;
use app\models\User;

/* @var $this yii\web\View */
/* @var $model app\models\Grade */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="grade-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="form-group">        
    <label for="requirement">Requirement</label>
    <?= Html::activeDropDownList($model, 'requirement_id',
                ArrayHelper::map(Requirement::find()->all(), 'requirement_id', 'description'),
                ['id' => 'requirement_id', 'class' => 'form-control']) ?>
    </div>

    <?= $form->field($model, 'student_no')->textInput(['maxlength' => 10]) ?>

    <?= $form->field($model, 'student_no')->textInput(['maxlength' => 10]) ?>

    <?= $form->field($model, 'grade')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
