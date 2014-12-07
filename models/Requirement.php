<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "requirement".
 *
 * @property integer $requirement_id
 * @property string $description
 * @property integer $title
 * @property integer $category_id
 *
 * @property Grade[] $grades
 * @property Category $category
 */
class Requirement extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'requirement';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description', 'title', 'category_id'], 'required'],
            [['title', 'category_id'], 'string', 'max' => 200],
            [['description'], 'string', 'max' => 800],
            [['perfect_grade'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'requirement_id' => 'Requirement ID',
            'description' => 'Description/Instruction',
            'title' => 'Title',
            'category_id' => 'Category ID',
            'perfect_grade' => 'Perfect Grade',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGrades()
    {
        return $this->hasMany(Grade::className(), ['requirement_id' => 'requirement_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['category_id' => 'category_id']);
    }
    
    // Retrieves category description of the passed category_id
    public static function findCategory($category_id)
    {
        $model = Category::find()->where(['category_id' => $category_id])->one();
        return $model;
    }
}
