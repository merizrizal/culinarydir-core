<?php

namespace core\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use core\models\PersonAsDriver;

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
            [['person_id', 'district_id', 'no_ktp', 'no_sim', 'date_birth', 'motor_brand', 'motor_type', 'emergency_contact_name', 'emergency_contact_phone', 'emergency_contact_address', 'number_plate', 'stnk_expired', 'created_at', 'user_created', 'updated_at', 'user_updated', 'other_driver'], 'safe'],
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
        $query = PersonAsDriver::find();

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
            'date_birth' => $this->date_birth,
            'stnk_expired' => $this->stnk_expired,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['ilike', 'person_id', $this->person_id])
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
