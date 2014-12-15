<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\base\BootstrapInterface;
use yii\web\ForbiddenHttpException;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
if($isAdmin){

    // if ($isAdmin) {
    //     ///////////////////////////////////

    //     // get requirement IDs in a category
    //     function getRequirementIDs( $categoryID ){

    //         $requirements = (new \yii\db\Query())
    //             ->select('requirement_id')
    //             ->from('requirement')
    //             ->where([
    //                 'category_id' => $categoryID,
    //             ])
    //             ->all();

    //         return $requirements;

    //     };

    //     //get grade with student_no and requirement_id
    //     function getGrade( $reqid, $studno ){
    //         $grade = (new \yii\db\Query())
    //             ->select('grade')
    //             ->from('grade')
    //             ->where([
    //                 'requirement_id' => $reqid,
    //                 'student_no' => $studno,
    //             ])
    //             ->one();

    //            $grad = implode("",$grade);
    //            // print "| grade = $grad |";
    //            return $grad;
    //     }

    //     // get average of the same category
    //     function getAverageSameCategory($categoryID, $stud_no){

    //         $requirements = getRequirementIDs( $categoryID );

    //         $count = 0;
    //         $total = 0;
    //         foreach ( $requirements as $req ){
    //             $count = $count + 1;
    //             $reqid = ((int)implode("",$req));
    //             $grad = (int)getGrade($reqid, $stud_no);
    //             // print "| grade = $grad |";
    //             $total = $total + $grad;
    //         }
    //         $average = $total / $count; 
    //         // print "| total = $total |";
    //         // print "| count = $count |";
    //         // print "| average = $average |";

    //         return $average;
    //     };

    //     // get percentage of category
    //     function getPercentageOfCategory($categoryID){

    //         $percentage = (new \yii\db\Query())
    //             ->select('percentage')
    //             ->from('category')
    //             ->where([
    //                 'category_id' => $categoryID,
    //             ])
    //             ->one();
    //         $percent = implode(" ", $percentage);
    //         // print "percent = $percent | ";
    //         return $percent;  
    //     };

    //     // get average * percentage in category
    //     function getPartTotal($catID,$studno){
    //         $percent = getPercentageOfCategory($catID);
    //         $average = getAverageSameCategory($catID,$studno);
    //         $gradeInCategory = ($percent / 100) * $average;

    //         // print "| percent = $percent | ";
    //         // print "| average = $average | ";
    //         // print "| gradeInCategory = $gradeInCategory |";

    //         return $gradeInCategory;
    //     };

    //     // get each category IDs & get total average
    //     function getTotalAverage($stud_no){
    //         $categories = (new \yii\db\Query())
    //             ->select('category_id')
    //             ->from('category')
    //             ->all();

    //         $fullTotalGrade = 0;
    //         foreach($categories as $cat){
    //             $category = implode (" ",$cat);
    //             // print "| $category |";
    //             $fullTotalGrade = $fullTotalGrade + getPartTotal($cat,$stud_no);
    //         };
    //         // print "Total Grade = $fullTotalGrade %";
    //         return $fullTotalGrade;
    //     };


    //     // get Average per Student No.
    //     foreach ($dataProvider->models as $stud_no){
    //         if ($stud_no->user_type == '1'){
    //             $totalAverage = getTotalAverage($stud_no->student_no);
    //             $studno = $stud_no->student_no;
    //             print nl2br("Student No: $studno | Average: $totalAverage \n");
    //         }
    //     };

    //     ///////////////////////////////////
    // };


 // print $dataProvider->models[0]->student_no;


    $this->title = 'Users';
    $this->params['breadcrumbs'][] = $this->title;
    ?>
    <div class="user-index">
    
        <h1><?= Html::encode($this->title) ?></h1>
        
        <?php if($isAdmin){ ?>
            <p>
                <?= Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?>
            </p>
        <?php }  ?>
    
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                 'attribute' => 'student_no',
                 'format' => 'raw',
                 'value' => function ($model, $key, $index) { 
                    return Html::a($model->student_no, ['view', 'id' => $model->user_id]);
                 },
                ],
    
                //'user_type',
               // 'student_no',
                //'username',
                //'password',
                'lname',
                'fname',
                // 'user_id',
    
                ['class' => 'yii\grid\ActionColumn',
                 'buttons' => [                
                    'delete' => function ($url, $model, $key) {
                        // Have to redeclare for local scope
                        $isGuest = Yii::$app->User->isGuest;
                        $isAdmin = ((!$isGuest)&&(Yii::$app->User->identity->user_type == 0));
                        
                        return $isAdmin ? Html::a('<span class="glyphicon glyphicon-trash"></span>', $url) : '';
                    }
                 ], 
                ],
            ],
        ]); ?>
        </div>
                    
<?php } else throw new ForbiddenHttpException('You are not allowed to access this page.'); ?>
        


