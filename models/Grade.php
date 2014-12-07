<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "grade".
 *
 * @property integer $requirement_id
 * @property string $student_no
 * @property double $grade
 *
 * @property User $studentNo
 * @property Requirement $requirement
 */
class Grade extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'grade';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['requirement_id', 'student_no', 'grade'], 'required'],
            [['requirement_id'], 'integer'],
            [['grade'], 'number'],
            [['student_no'], 'string', 'max' => 10]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'requirement_id' => 'Requirement ID',
            'student_no' => 'Student Number',
            'grade' => 'Grade',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudentNo()
    {
        return $this->hasOne(User::className(), ['student_no' => 'student_no']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRequirement()
    {
        return $this->hasOne(Requirement::className(), ['requirement_id' => 'requirement_id']);
    }
    
    // Retrieves category description of the passed category_id
    public static function findRequirementDescription($requirement_id)
    {
        $model = Requirement::find()->where(['requirement_id' => $requirement_id])->one();
        return $model;
    }
}
