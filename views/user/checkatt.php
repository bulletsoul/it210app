<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
yii\web\JqueryAsset::register($this);
/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Check Attendance';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn',
             'visible' => false
            ],

            //'user_type',
            //'student_no',
            //'username',
            //'password',
            'lname',
            'fname',
          //  'user_id',
            'att_no',
            //['class' => 'yii\grid\ActionColumn'],
            ['class' => 'yii\grid\CheckboxColumn',
             'header' => 'Present'
            ],
        ],
    ]); ?>
	
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
                //$("input[type=checkbox]").click(function(){
                    $("#2").click(function(){
                      
                      var keys = $('#w0').yiiGridView('getSelectedRows');       
                      //alert(keys[0]);               
                     $.ajax({
                      url: '<?php echo Yii::$app->urlManager->createUrl("user/index");?>', // your controller action
                      //data: {keylist: keys},
                      data: "keylist="+keys,
                      success: function(data) {
                        //alert('I did it! Processed checked rows. '+data);
                        return false;
                        },
                        error: function(data){
                          //  alert('error: '+data);
                        }
                    });    
                    
                      //alert(keys[0]);
                       //alert('om');
                });
        });
    </script>
    <button id="2">Submit</button>
    
</div>
