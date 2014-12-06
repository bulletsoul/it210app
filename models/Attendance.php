<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "attendance".
 *
 * @property string $student_no
 * @property string $date
 *
 * @property User $studentNo
 */
class Attendance extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'attendance';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['student_no', 'date'], 'required'],
            [['date'], 'safe'],
            [['student_no'], 'string', 'max' => 10]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'student_no' => 'Student Number',
            'date' => 'Date ',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudentNo()
    {
        return $this->hasOne(User::className(), ['student_no' => 'student_no']);
    }
}
