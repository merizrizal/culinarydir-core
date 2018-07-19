<?php

namespace core\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use core\models\RegistryBusiness;

/**
 * RegistryBusinessSearch represents the model behind the search form of `core\models\RegistryBusiness`.
 */
class RegistryBusinessSearch extends RegistryBusiness
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id','membership_type_id', 'city_id', 'district_id', 'village_id', 'user_in_charge', 'user_created', 'user_updated'], 'integer'],
            [['name', 'unique_name', 'email', 'phone1', 'phone2', 'phone3', 'address_type', 'address', 'address_info', 'coordinate', 'status', 'created_at', 'updated_at',
                'membershipType.name'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributes() {
        // add related fields to searchable attributes
        return array_merge(parent::attributes(), ['membershipType.name']);
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
        $query = RegistryBusiness::find()
                ->joinWith([
                    'membershipType',
                    'userInCharge',
                ]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => array(
                'pageSize' => Yii::$app->params['pageSize'],
            ),
        ]);

        $dataProvider->sort->attributes['membershipType.name'] = [
            'asc' => ['membership_type.name' => SORT_ASC],
            'desc' => ['membership_type.name' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'registry_business.id' => $this->id,
            'registry_business.membership_type_id' => $this->membership_type_id,
            'registry_business.city_id' => $this->city_id,
            'registry_business.district_id' => $this->district_id,
            'registry_business.village_id' => $this->village_id,
            'registry_business.status' => $this->status,
            'registry_business.user_in_charge' => $this->user_in_charge,
            '(registry_business.created_at + interval \'7 hour\')::date' => $this->created_at,
            'registry_business.user_created' => $this->user_created,
            '(registry_business.updated_at + interval \'7 hour\')::date' => $this->updated_at,
            'registry_business.user_updated' => $this->user_updated,
        ]);

        $query->andFilterWhere(['ilike', 'registry_business.name', $this->name])
                ->andFilterWhere(['ilike', 'unique_name', $this->unique_name])
                ->andFilterWhere(['ilike', 'registry_business.email', $this->email])
                ->andFilterWhere(['ilike', 'registry_business.phone1', $this->phone1])
                ->andFilterWhere(['ilike', 'registry_business.phone2', $this->phone2])
                ->andFilterWhere(['ilike', 'registry_business.phone3', $this->phone3])
                ->andFilterWhere(['ilike', 'registry_business.address_type', $this->address_type])
                ->andFilterWhere(['ilike', 'registry_business.address', $this->address])
                ->andFilterWhere(['ilike', 'registry_business.address_info', $this->address_info])
                ->andFilterWhere(['ilike', 'registry_business.coordinate', $this->coordinate])
                ->andFilterWhere(['membership_type.name' => $this->getAttribute('membershipType.name')]);

        return $dataProvider;
    }
}
