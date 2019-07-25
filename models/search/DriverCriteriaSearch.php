<?php

namespace core\models\search;

use core\models\DriverCriteria;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * DriverCriteriaSearch represents the model behind the search form of `core\models\DriverCriteria`.
 */
class DriverCriteriaSearch extends DriverCriteria
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'person_as_driver_id', 'criteria_name', 'type', 'created_at',
                'user_created', 'updated_at', 'user_updated',
                'personAsDriver.person.first_name', 'personAsDriver.no_sim'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributes() {
        // add related fields to searchable attributes
        return array_merge(parent::attributes(), ['personAsDriver.person.first_name', 'personAsDriver.no_sim']);
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
        $query = DriverCriteria::find()
            ->joinWith(['personAsDriver.person']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['ilike', 'id', $this->id])
            ->andFilterWhere(['ilike', 'person_as_driver_id', $this->person_as_driver_id])
            ->andFilterWhere(['ilike', 'criteria_name', $this->criteria_name])
            ->andFilterWhere(['ilike', 'type', $this->type])
            ->andFilterWhere(['ilike', 'user_created', $this->user_created])
            ->andFilterWhere(['ilike', 'user_updated', $this->user_updated])
            ->andFilterWhere(['ilike', 'personAsDriver.person.first_name', $this->getAttribute('personAsDriver.person.first_name')])
            ->andFilterWhere(['ilike', 'personAsDriver.no_sim', $this->getAttribute('personAsDriver.no_sim')]);

        return $dataProvider;
    }
}
