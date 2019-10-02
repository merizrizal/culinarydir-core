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
            'sort' => [
                'defaultOrder' => ['created_at' => SORT_ASC]
            ],
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
            'is_criteria_passed' => $this->is_criteria_passed,
            '(registry_driver.created_at + interval \'7 hour\')::date' => $this->created_at,
        ]);

        $query->andFilterWhere(['ilike', 'first_name', $this->first_name])
            ->andFilterWhere(['ilike', 'phone', $this->phone])
            ->andFilterWhere(['ilike', 'number_plate', $this->number_plate])
            ->andFilterWhere(['ilike', 'user.full_name', $this->getAttribute('userInCharge.full_name')]);

        return $dataProvider;
    }
}
