<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php
        $form = ActiveForm::begin();
        
        // Get where the request for _form came from
        // Could only be from either update or create
        $isUpdate = ($from == 'update_user');
        $isGuest = Yii::$app->User->isGuest;
        $isAdmin = ((!$isGuest)&&(Yii::$app->User->identity->user_type == 0));
    ?>
    
    <?php if(!$isUpdate && $isAdmin){ ?>
        <?= $form->field($model, 'user_type')->textInput() ?>
    <?php } ?>    

    <?= $form->field($model, 'student_no')->textInput(['maxlength' => 10, 'readonly' => $isUpdate]) ?>

    <?php if(!$isUpdate){ ?>
        <?= $form->field($model, 'username')->textInput(['maxlength' => 30]) ?>
    
        <?= $form->field($model, 'password')->passwordInput(['maxlength' => 800]) ?>
    <?php } ?>

    <?= $form->field($model, 'fname')->textInput(['maxlength' => 30]) ?>
    
    <?= $form->field($model, 'lname')->textInput(['maxlength' => 30]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
