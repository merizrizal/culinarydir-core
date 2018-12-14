<?php

namespace core\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use core\models\BusinessProduct;

/**
 * BusinessProductSearch represents the model behind the search form of `core\models\BusinessProduct`.
 */
class BusinessProductSearch extends BusinessProduct
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'business_id', 'price', 'user_created', 'user_updated', 'order'], 'integer'],
            [['name', 'description', 'image', 'created_at', 'updated_at'], 'safe'],
            [['not_active'], 'boolean'],
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
        $query = BusinessProduct::find()
            ->orderBy('order ASC');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => array(
                'pageSize' => 15,
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
            'business_id' => $this->business_id,
            'price' => $this->price,
            'not_active' => $this->not_active,
            'created_at' => $this->created_at,
            'user_created' => $this->user_created,
            'updated_at' => $this->updated_at,
            'user_updated' => $this->user_updated,
            'order' => $this->order,
        ]);

        $query->andFilterWhere(['ilike', 'name', $this->name])
            ->andFilterWhere(['ilike', 'description', $this->description])
            ->andFilterWhere(['ilike', 'image', $this->image]);

        return $dataProvider;
    }
}
