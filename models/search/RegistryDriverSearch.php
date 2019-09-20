<?php

namespace core\models\search;

use core\models\RegistryDriver;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * RegistryDriverSearch represents the model behind the search form of `core\models\RegistryDriver`.
 */
class RegistryDriverSearch extends RegistryDriver
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['is_criteria_passed'], 'boolean'],
            [['application_driver_counter'], 'integer'],
            [['id', 'first_name', 'last_name', 'email', 'phone', 'district_id', 'no_ktp', 'no_sim', 'date_birth', 'motor_brand', 'motor_type', 'emergency_contact_name', 'emergency_contact_phone', 'emergency_contact_address', 'number_plate', 'stnk_expired', 'other_driver', 'created_at', 'user_created', 'updated_at', 'user_updated', 'application_driver_id', 'user_in_charge',
                'userInCharge.full_name'], 'safe'],
        ];
    }

    public function attributes() {
        // add related fields to searchable attributes
        return array_merge(parent::attributes(), ['userInCharge.full_name']);
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
        $query = RegistryDriver::find()
            ->select('user.full_name, registry_driver.*')
            ->joinWith([
                'applicationDriver',
                'applicationDriver.logStatusApprovalDrivers',
                'userInCharge'
            ]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => array(
                'pageSize' => \Yii::$app->params['pageSize'],
            ),
        ]);

        $dataProvider->sort->attributes['userInCharge.full_name'] = [
            'asc' => ['user.full_name' => SORT_ASC],
            'desc' => ['user.full_name' => SORT_DESC],
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
            'is_criteria_passed' => $this->is_criteria_passed,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'application_driver_counter' => $this->application_driver_counter,
        ]);

        $query->andFilterWhere(['ilike', 'id', $this->id])
            ->andFilterWhere(['ilike', 'first_name', $this->first_name])
            ->andFilterWhere(['ilike', 'last_name', $this->last_name])
            ->andFilterWhere(['ilike', 'email', $this->email])
            ->andFilterWhere(['ilike', 'phone', $this->phone])
            ->andFilterWhere(['ilike', 'no_ktp', $this->no_ktp])
            ->andFilterWhere(['ilike', 'no_sim', $this->no_sim])
            ->andFilterWhere(['ilike', 'motor_brand', $this->motor_brand])
            ->andFilterWhere(['ilike', 'motor_type', $this->motor_type])
            ->andFilterWhere(['ilike', 'emergency_contact_name', $this->emergency_contact_name])
            ->andFilterWhere(['ilike', 'emergency_contact_phone', $this->emergency_contact_phone])
            ->andFilterWhere(['ilike', 'emergency_contact_address', $this->emergency_contact_address])
            ->andFilterWhere(['ilike', 'number_plate', $this->number_plate])
            ->andFilterWhere(['ilike', 'other_driver', $this->other_driver])
            ->andFilterWhere(['ilike', 'user_created', $this->user_created])
            ->andFilterWhere(['ilike', 'user_updated', $this->user_updated])
            ->andFilterWhere(['ilike', 'district_id', $this->district_id])
            ->andFilterWhere(['ilike', 'application_driver_id', $this->application_driver_id])
            ->andFilterWhere(['ilike', 'user_in_charge', $this->user_in_charge])
            ->andFilterWhere(['ilike', 'user.full_name', $this->getAttribute('userInCharge.full_name')]);

        return $dataProvider;
    }
}
