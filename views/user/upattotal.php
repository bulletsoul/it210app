<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
	<h3>Maximum number:<?= Html::encode("{$teacher->att_no}") ?> </h3>
	<?= Html::label('Enter new value:') ?>
	<?= Html::textInput('txtNewMax','',['id'=>5,'maxlength' => 10]) ?> 
	<?= Html::button('Update',['id'=>'3','class' => 'btn btn-primary', 'name' => 'update-button'])   ?>

<?php $form = ActiveForm::begin(); ?>
    <div class="form-group">
		<?= Html::submitButton('Reload', ['id'=>'1','class' => 'btn btn-success', 'name' => 'attendance-button']) ?>
		</div>
<?php ActiveForm::end(); ?>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
                    $("#3").click(function(){
                    			var totAtt = document.getElementById("5").value;
                    			$.ajax({
                     			url: '<?php echo Yii::$app->urlManager->createUrl("user/upattotal");?>', // your controller action
		                      data: "attValue="+totAtt,
    		                  success: function(data) {
    					                 // alert('I did it! Processed checked rows. '+data);
    				                    return false;
                        	},
                        	error: function(data){
                          		  alert('error: '+data);
                        		}
                    			}); s
                });
        });
    </script>
