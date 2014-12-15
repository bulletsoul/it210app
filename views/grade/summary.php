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
                ->select('requirement_id')
                ->from('requirement')
                ->where([
                    'category_id' => $categoryID,
                ])
                ->all();

            return $requirements;

        };

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

            $count = 0;
            $total = 0;
            foreach ( $requirements as $req ){
                $count = $count + 1;
                $reqid = ((int)implode("",$req)) - 1;
                $total = $total + $dataP->models[$reqid]->grade;
            }
            $average = $total / $count; 
            // print "$total = ";
            // print "$count = ";
            // print "$average ";

            return $average;
        };

       // Admin get average of the same category
        function getAverageSameCategory_admin($categoryID, $stud_no){

            $requirements = getRequirementIDs( $categoryID );

            $count = 0;
            $total = 0;
            foreach ( $requirements as $req ){
                $count = $count + 1;
                $reqid = ((int)implode("",$req));
                $grad = (int)getGrade($reqid, $stud_no);
                // print "| grade = $grad |";
                $total = $total + $grad;
            }
            $average = $total / $count; 
            // print "| total = $total |";
            // print "| count = $count |";
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

        if (!$isAdmin) {

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
                print "Total Grade = $fullTotalGrade %";
        }
        else{

            // get Average per Student No.
            // SELECT `student_no` FROM `user` WHERE `user_type` = 1;
            $users = (new \yii\db\Query())
                ->select('student_no')//, lname, fname')
                ->from('user')
                ->where([
                    'user_type' => '1',
                ])
                ->all();
                // ->one();
            // print_r($users); 


            
            ?> 

            <h1>Summary of Grades</h1>
                <table border=1 width="100%" bordercolor="f1f1f1">
                            <th><font color="428bca">Student No.</font></th>
                            <th><font color="428bca">Average Grade</font></th>
                        
                            <?php
                            $i = 0;
                            foreach($users as $stud_no) {
                                $i++;
                                $totalAverage = getTotalAverage($stud_no);
                                $studn = implode(" ",$stud_no);
                                if($i%2==0){
                                ?>
                                <tr bgcolor="#F9f9f9">
                                    <td>
                                        <?php print nl2br($studn); ?> 

                                    </td>
                                    <td>
                                         <?php print nl2br($totalAverage); ?>
                                    </td>
                                </tr>
                                <?php
                                }else{
                                    ?>
                                    <tr>
                                        <td>
                                            <?php print nl2br($studn); ?> 

                                        </td>
                                        <td>
                                             <?php print nl2br($totalAverage); ?>
                                        </td>
                                    </tr>       

                                <?php
                            };
                                };
                            ?>
                        
                    
                </table>
        <?php
        };
        ///////////////////////////////////


    $this->title = $from_req_page ? 'Grades for '.$req->title.'('.$req->perfect_grade.')' : 'Grades';

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
            $grade_column = !$from_req_page ? 'grade' :
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
                $grade_column,
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
                'student_no',
                [
                    'attribute' => 'student_name',
                    'value' => function ($model) {
                        $val = $model->findStudentName($model->student_no);
                        return $val->lname.', '.$val->fname;
                    },
                    'enableSorting' => true
                ],

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

<?php

