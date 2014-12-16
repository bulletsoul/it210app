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

    <div class="form-group">        
    <label for="user">Student Name</label>
    <?= Html::activeDropDownList($model, 'student_no',
                ArrayHelper::map(User::find()->all(), 'student_no', 'lname','fname'),
                ['id' => 'student_no', 'class' => 'form-control']) ?>
    </div>

    <?= $form->field($model, 'grade')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
