<?php

namespace core\models\search;

use core\models\StatusApproval;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * StatusApprovalSearch represents the model behind the search form of `core\models\StatusApproval`.
 */
class StatusApprovalSearch extends StatusApproval
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'name', 'note', 'instruction', 'status', 'execute_action', 'created_at', 'updated_at'], 'safe'],
            [['order', 'branch', 'group', 'user_created', 'user_updated'], 'integer'],
            [['condition', 'not_active'], 'boolean'],
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
        $query = StatusApproval::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> [
                'defaultOrder' => ['order' => SORT_ASC]
            ],
            'pagination' => array(
                'pageSize' => \Yii::$app->params['pageSize'],
            ),
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'order' => $this->order,
            'condition' => $this->condition,
            'branch' => $this->branch,
            'group' => $this->group,
        ]);

        $query->andFilterWhere(['ilike', 'id', $this->id])
            ->andFilterWhere(['ilike', 'name', $this->name]);

        return $dataProvider;
    }
}
