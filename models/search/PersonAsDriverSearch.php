<?php

namespace core\models\search;

use core\models\PersonAsDriver;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * PersonAsDriverSearch represents the model behind the search form of `core\models\PersonAsDriver`.
 */
class PersonAsDriverSearch extends PersonAsDriver
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['person.first_name', 'district_id', 'no_ktp', 'no_sim', 'date_birth', 'motor_brand', 'motor_type',
                'emergency_contact_name', 'emergency_contact_phone', 'emergency_contact_address', 'number_plate',
                'stnk_expired', 'created_at', 'user_created', 'updated_at', 'user_updated', 'other_driver'], 'safe'],
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
     * @inheritdoc
     */
    public function attributes() {
        // add related fields to searchable attributes
        return array_merge(parent::attributes(), ['person.first_name']);
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
        $query = PersonAsDriver::find()
            ->joinWith(['person']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => array(
                'pageSize' => \Yii::$app->params['pageSize'],
            ),
        ]);

        $dataProvider->sort->attributes['person.first_name'] = [
            'asc' => ['person.first_name' => SORT_ASC],
            'desc' => ['person.first_name' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'date_birth' => $this->date_birth,
            'stnk_expired' => $this->stnk_expired,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['ilike', 'person.first_name', $this->getAttribute('person.first_name')])
            ->andFilterWhere(['ilike', 'district_id', $this->district_id])
            ->andFilterWhere(['ilike', 'no_ktp', $this->no_ktp])
            ->andFilterWhere(['ilike', 'no_sim', $this->no_sim])
            ->andFilterWhere(['ilike', 'motor_brand', $this->motor_brand])
            ->andFilterWhere(['ilike', 'motor_type', $this->motor_type])
            ->andFilterWhere(['ilike', 'emergency_contact_name', $this->emergency_contact_name])
            ->andFilterWhere(['ilike', 'emergency_contact_phone', $this->emergency_contact_phone])
            ->andFilterWhere(['ilike', 'emergency_contact_address', $this->emergency_contact_address])
            ->andFilterWhere(['ilike', 'number_plate', $this->number_plate])
            ->andFilterWhere(['ilike', 'user_created', $this->user_created])
            ->andFilterWhere(['ilike', 'user_updated', $this->user_updated])
            ->andFilterWhere(['ilike', 'other_driver', $this->other_driver]);

        return $dataProvider;
    }
}
