<?php

namespace core\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use core\models\RegistryBusinessPayment;

/**
 * RegistryBusinessPaymentSearch represents the model behind the search form of `core\models\RegistryBusinessPayment`.
 */
class RegistryBusinessPaymentSearch extends RegistryBusinessPayment
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'registry_business_id', 'payment_method_id', 'user_created', 'user_updated'], 'integer'],
            [['unique_id', 'created_at', 'updated_at', 'note'], 'safe'],
            [['is_active'], 'boolean'],
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
        $query = RegistryBusinessPayment::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => array(
                'pageSize' => Yii::$app->params['pageSize'],
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
            'id' => $this->id,
            'registry_business_id' => $this->registry_business_id,
            'payment_method_id' => $this->payment_method_id,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at,
            'user_created' => $this->user_created,
            'updated_at' => $this->updated_at,
            'user_updated' => $this->user_updated,
        ]);

        $query->andFilterWhere(['ilike', 'unique_id', $this->unique_id])
            ->andFilterWhere(['ilike', 'note', $this->note]);

        return $dataProvider;
    }
}
