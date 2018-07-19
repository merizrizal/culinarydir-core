<?php

namespace core\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use core\models\Product;

/**
 * ProductSearch represents the model behind the search form of `core\models\Product`.
 */
class ProductSearch extends Product
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id','product_category_id',  'user_created', 'user_updated'], 'integer'],
            [['name', 'note', 'is_active', 'created_at', 'updated_at',
                'productCategory.name'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributes() {
        // add related fields to searchable attributes
        return array_merge(parent::attributes(), ['productCategory.name']);
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
        $query = Product::find()
                ->joinWith(['productCategory']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => array(
                'pageSize' => Yii::$app->params['pageSize'],
            ),
        ]);

        $dataProvider->sort->attributes['productCategory.name'] = [
            'asc' => ['product_category.name' => SORT_ASC],
            'desc' => ['product_category.name' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'product.id' => $this->id,
            'product.product_category_id' => $this->product_category_id,
            'product.is_active' => $this->is_active,
            'product.created_at' => $this->created_at,
            'product.user_created' => $this->user_created,
            'product.updated_at' => $this->updated_at,
            'product.user_updated' => $this->user_updated,
        ]);

        $query->andFilterWhere(['ilike', 'product.name', $this->name])
                ->andFilterWhere(['ilike', 'product.note', $this->note])
                ->andFilterWhere(['ilike', 'product_category.name', $this->getAttribute('productCategory.name')]);

        return $dataProvider;
    }
}
