<?php

namespace core\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use core\models\PromoItem;

/**
 * PromoItemSearch represents the model behind the search form of `core\models\PromoItem`.
 */
class PromoItemSearch extends PromoItem
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'promo_id', 'user_claimed', 'business_claimed', 'created_at', 'user_created', 'updated_at', 'user_updated'], 'safe'],
            [['amount'], 'integer'],
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
        $query = PromoItem::find();

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
            'amount' => $this->amount,
            'not_active' => $this->not_active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['ilike', 'id', $this->id])
            ->andFilterWhere(['ilike', 'promo_id', $this->promo_id])
            ->andFilterWhere(['ilike', 'user_claimed', $this->user_claimed])
            ->andFilterWhere(['ilike', 'business_claimed', $this->business_claimed])
            ->andFilterWhere(['ilike', 'user_created', $this->user_created])
            ->andFilterWhere(['ilike', 'user_updated', $this->user_updated]);

        return $dataProvider;
    }
}
