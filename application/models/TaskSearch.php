<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Task;

/**
 * TaskSearch represents the model behind the search form of `app\models\Task`.
 */
class TaskSearch extends Task
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'priority_id'], 'integer'],
            [['created_at', 'updated_at', 'label', 'description', 'start_date', 'deadline_date', 'cancelled'], 'safe'],
            [['duration'], 'number'],
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
        $query = Task::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'priority_id' => $this->priority_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'duration' => $this->duration,
            'start_date' => $this->start_date,
            'deadline_date' => $this->deadline_date,
        ]);

        $query->andFilterWhere(['like', 'label', $this->label])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'cancelled', $this->cancelled]);

        return $dataProvider;
    }
}
