<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Grade;
use app\models\Requirement;
use app\models\User;

/**
 * GradeSearch represents the model behind the search form about `app\models\Grade`.
 */
class GradeSearch extends Grade
{
    public $requirement;
    public $student_name;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['requirement_id'], 'integer'],
            [['student_no','student_name','requirement'], 'safe'],
            [['grade'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Grade::find();

        $query->joinWith(['requirement','studentNo']);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        // Important: here is how we set up the sorting
        // The key is the attribute name on our "TourSearch" instance
        $dataProvider->sort->attributes['requirement'] = [
            // The tables are the ones our relation are configured to
            'asc' => ['requirement.title' => SORT_ASC],
            'desc' => ['requirement.title' => SORT_DESC],
        ];
        
        $dataProvider->sort->attributes['student_name'] = [
            'asc' => ['user.lname' => SORT_ASC],
            'desc' => ['user.lname' => SORT_DESC],
        ];

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'requirement.requirement_id' => $this->requirement_id,
            'user.student_no' => $this->student_no,
            'grade' => $this->grade,
        ]);

        return $dataProvider;
    }
}
