<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;
use kartik\grid\EditableColumn;
use yii\bootstrap\BootstrapAsset;
use yii\web\ForbiddenHttpException;


/* @var $this yii\web\View */
/* @var $searchModel app\models\GradeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
if(!$isGuest){

        ///////////////////////////////////
        // get requirement IDs in a category
        function getRequirementIDs( $categoryID ){

            $requirements = (new \yii\db\Query())
                ->select('requirement_id,perfect_grade')
                ->from('requirement')
                ->where([
                    'category_id' => $categoryID,
                ])
                ->all();

            // print_r($requirements);

            // foreach ($requirements as $reqid){
            //     foreach ($reqid as $key => $value) {
            //         if ($key == "requirement_id"){
            //             print ("requirement_id : $value ");
            //         } else {
            //             print nl2br("perfect_grade: $value\n");
            //         };
            //         // print nl2br("Key: $key; Value: $value\n");
            //     }
            // }    
            return $requirements;

        };

        // getRequirementIDs('3');

        //get grade with student_no and requirement_id
        function getGrade( $reqid, $studno ){
            $grade = (new \yii\db\Query())
                ->select('grade')
                ->from('grade')
                ->where([
                    'requirement_id' => $reqid,
                    'student_no' => $studno,
                ])
                ->one();
                if($grade!=NULL){
               $grad = implode("",$grade);
               // print "| grade = $grad |";
               return $grad;
           }
        }

        // Student get average of the same category 
        function getAverageSameCategory_student($categoryID, $dataP){
            
            $requirements = getRequirementIDs( $categoryID );

            $perfect_total = 0;
            $total = 0;
            foreach ($requirements as $r){
                foreach ( $r as $key => $value ){
                    if ($key == "requirement_id"){
                        $reqid = $value - 1;
                        $total = $total + $dataP->models[$reqid]->grade;
                    } else {
                        $p_grade = $value;
                        $perfect_total = $perfect_total + $p_grade;
                    }
                }
            }
            $average = $total / $perfect_total; 
            // print "$total = ";
            // print "$perfect_total = ";
            // print "$average ";

            return $average;
        };

       // Admin get average of the same category
        function getAverageSameCategory_admin($categoryID, $stud_no){

            $requirements = getRequirementIDs( $categoryID );

            $perfect_total = 0;
            $total = 0;
            foreach ( $requirements as $r){
                foreach ( $r as $key => $value ){
                    if ($key == 'requirement_id'){
                        $reqid = ((int)$value);
                        $grad = (int)getGrade($reqid, $stud_no);
                        $total = $total + $grad;
                        // print nl2br("reqid = $reqid\n");
                        // print nl2br("grade = $grad\n");
                    } else {
                        $p_grade = ((int)$value);
                        $perfect_total = $perfect_total + $p_grade;
                        // print nl2br("perfect grade = $p_grade\n");
                    }
                    // print "| grade = $grad |";

                }
            }
            $ave = $total / $perfect_total; 
            $average = $ave * 100;
            // print "| total = $total |";
            // print "| perfect_total = $perfect_total |";
            // print "| average = $average |";

            return $average;
        };

        // get percentage of category
        function getPercentageOfCategory($categoryID){

            $percentage = (new \yii\db\Query())
                ->select('percentage')
                ->from('category')
                ->where([
                    'category_id' => $categoryID,
                ])
                ->one();
            $percent = implode(" ", $percentage);
            // print "percent = $percent | ";
            return $percent;  
        };

        // get average * percentage in category
        function getPartTotal($catID, $data, $profOrStud){
            $percent = getPercentageOfCategory($catID);
            $profOrStud ? $average = getAverageSameCategory_student($catID, $data) :
                $average = getAverageSameCategory_admin($catID, $data);
            $gradeInCategory = ($percent / 100) * $average;

            // print "| percent = $percent | ";
            // print "| average = $average | ";
            // print "| gradeInCategory = $gradeInCategory |";

            return $gradeInCategory;
        };

        function getTotalAverage($stud_no){
            $categories = (new \yii\db\Query())
                ->select('category_id')
                ->from('category')
                ->all();

            $fullTotalGrade = 0;
            foreach($categories as $cat){
                $category = implode (" ",$cat);
                // print "| $category |";
                $fullTotalGrade = $fullTotalGrade + getPartTotal($cat,$stud_no,0);
            };
            // print "Total Grade = $fullTotalGrade %";
            return $fullTotalGrade;
        };

        if (!$isAdmin && !$from_req_page) {

            // get each category IDs & get total average
                $categories = (new \yii\db\Query())
                    ->select('category_id')
                    ->from('category')
                    ->all();

                $fullTotalGrade = 0;
                foreach($categories as $cat){
                    $category = implode (" ",$cat);
                    // print "| $category |";
                    $fullTotalGrade = $fullTotalGrade + getPartTotal($cat,$dataProvider,1);
                };
				$fTotalGrade = $fullTotalGrade*100;
				?>
				<span class="label label-warning">Current Standing:</span><?= $fTotalGrade ?>%
				<?php
        }
        else{

            // get Average per Student No.
            // SELECT `student_no` FROM `user` WHERE `user_type` = 1;
            $users = (new \yii\db\Query())
                ->select('student_no, lname, fname')
                ->from('user')
                ->where([
                    'user_type' => '1',
                ])
                ->all();
                // ->one();
            // print_r($users); 
           
            ?> 

            <?php
            // foreach ( $users as $u){
            //     foreach ( $u as $key => $value ){
            //         if ($key == 'student_no'){
            //             $stud_no = $value;
            //             print nl2br("\nStudent No: $stud_no");
            //         } else if ($key == 'lname') {
            //             $lastname = $value;
            //             print nl2br("\nLast Name: $lastname");
            //         } else if ($key == 'fname') {
            //             $firstname = $value;
            //             print nl2br("\nFirst Name: $firstname");
            //         };
            //     };
            //     print nl2br("\nStudent No: $stud_no | Last Name: $lastname | First Name: $firstname");                
            // }
            ?>

             
			  <?= Html::a('View Summary of Grades', ['summary', 'dataProvider' => serialize($dataProvider), 'isGuest' => $isGuest, 'isAdmin' => $isAdmin], ['class' => 'btn btn-info']) ?>
               
        <?php
        };
        ///////////////////////////////////


    $this->title = $from_req_page ? 'Grades for '.$req->title.' ('.$req->perfect_grade.'/'.$req->perfect_grade.')' : 'Grades';

    $this->params['breadcrumbs'][] = $this->title;
    ?>
    <div class="grade-index">

        <h1><?= Html::encode($this->title) ?></h1>
        <?php  //echo $this->render('_search', ['model' => $searchModel]); ?>

        <?php if ($isAdmin) {?>
        <p>
            <?= Html::a('Create Grade', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
        <?php }; ?>
        
        <?php
            $grade_column = ((!$from_req_page && $isAdmin) || (!$isGuest && !$isAdmin)) ? 'grade' :
                [
                    'class' => 'kartik\grid\EditableColumn',
                    'attribute'=>'grade', 
                    'editableOptions' => [
                        'header' => 'Grade',
                        'inputType' => \kartik\editable\Editable::INPUT_SPIN,
                        'options' => [
                            'pluginOptions' => ['min'=>0, 'max'=>100]
                        ]
                    ],
                    'hAlign'=>'left', 
                    'vAlign'=>'middle',
                    'width'=>'200px',
                    'format'=>['decimal', 2],
                    'pageSummary' => true
                ];
            
            $gridColumns = [

                'student_no',
                [
                    'attribute' => 'student_name',
                    'value' => function ($model) {
                        $val = $model->findStudentName($model->student_no);
                        return $val->lname.', '.$val->fname;
                    },
                    'enableSorting' => true
                ],
                //'requirement_id',
                [
                    'attribute' => 'requirement',
                    /*'value' => function ($model) {
                        $val = $model->findRequirementDescription($model->requirement_id)->title;
                        return $val;
                    },*/
                    'value' => 'requirement.title',
                    'enableSorting' => true
                ],
                $grade_column,
            ];
        // end of grid columns definition
        ?>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            //'filterModel' => $searchModel,
            'columns' => $gridColumns/*[
                ['class' => 'yii\grid\SerialColumn'],

                'requirement_id',
                'student_no',
                'grade',

                ['class' => 'yii\grid\ActionColumn'],
            ],*/
        ]); ?>

    </div>


<?php } else throw new ForbiddenHttpException('You are not allowed to access this page.'); ?>


