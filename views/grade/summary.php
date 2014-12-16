<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;
use kartik\grid\EditableColumn;
use yii\bootstrap\BootstrapAsset;
use yii\web\ForbiddenHttpException;

$dataProvider = unserialize($dataProvider);

?>
<div class='grade-summary'>
<h1>Summary of Grades</h1>

<?php
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
                        $reqid = ((int)implode("",$value)) - 1;
                        $total = $total + $dataP->models[$reqid]->grade;
                    } else {
                        $p_grade = ((int)implode("",$value));
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
                // print "Total Grade = $fullTotalGrade %";
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

             
                <table border=1 width="100%" bordercolor="f1f1f1">
                            <th><font color="428bca">Student No.</font></th>
                            <th><font color="428bca">Last Name</font></th>
                            <th><font color="428bca">First Name</font></th>
                            <th><font color="428bca">Average Grade</font></th>
                       
                            <?php
                            $i = 0;
                            // foreach($users as $stud_no) {
                            foreach ( $users as $u){
                                $i++;
                                foreach ( $u as $key => $value ){
                                    if ($key == 'student_no'){
                                        $stud_no = $value;
                                        // print nl2br("\nStudent No: $stud_no");
                                    } else if ($key == 'lname') {
                                        $lastname = $value;
                                        // print nl2br("\nLast Name: $lastname");
                                    } else if ($key == 'fname') {
                                        $firstname = $value;
                                        // print nl2br("\nFirst Name: $firstname");
                                    };
                                };
                                $totalAverage = getTotalAverage($stud_no);
                                // $studn = implode(" ",$stud_no);
                                if($i%2==0){
                                ?>
                                <tr bgcolor="#F9f9f9">
                                    <td>
                                         <?php print nl2br($stud_no); ?> 

                                    </td>
                                    <td>
                                         <?php print nl2br($lastname); ?> 

                                    </td>
                                    <td>
                                         <?php print nl2br($firstname); ?> 

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
                                             <?php print nl2br($stud_no); ?> 

                                        </td>
                                        <td>
                                             <?php print nl2br($lastname); ?> 

                                        </td>
                                        <td>
                                             <?php print nl2br($firstname); ?> 

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

    ?>
</div>
<?php } else throw new ForbiddenHttpException('You are not allowed to access this page.'); ?>


