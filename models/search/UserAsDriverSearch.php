<?php

namespace core\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use core\models\UserAsDriver;

/**
 * UserAsDriverSearch represents the model behind the search form of `core\models\UserAsDriver`.
 */
class UserAsDriverSearch extends UserAsDriver
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'coordinate', 'socket_id', 'created_at', 'user_created', 'updated_at', 'user_updated',
                'user.username', 'user.email'], 'safe'],
            [['is_online',
                'user.not_active'], 'boolean'],
            [['total_cash'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributes() {
        // add related fields to searchable attributes
        return array_merge(parent::attributes(), ['user.username', 'user.email', 'user.not_active']);
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
        $query = UserAsDriver::find()
            ->joinWith(['user']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['created_at' => SORT_ASC]],
            'pagination' => array(
                'pageSize' => \Yii::$app->params['pageSize'],
            ),
        ]);

        $dataProvider->sort->attributes['user.username'] = [
            'asc' => ['user.username' => SORT_ASC],
            'desc' => ['user.username' => SORT_DESC]
        ];

        $dataProvider->sort->attributes['user.email'] = [
            'asc' => ['user.email' => SORT_ASC],
            'desc' => ['user.email' => SORT_DESC]
        ];

        $dataProvider->sort->attributes['user.not_active'] = [
            'asc' => ['user.not_active' => SORT_ASC],
            'desc' => ['user.not_active' => SORT_DESC]
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'user_as_driver.is_online' => $this->is_online,
            'user_as_driver.total_cash' => $this->total_cash,
            'user_as_driver.created_at' => $this->created_at,
            'user_as_driver.updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['ilike', 'user.username', $this->getAttribute('user.username')])
            ->andFilterWhere(['ilike', 'user.email', $this->getAttribute('user.email')])
            ->andFilterWhere(['user.not_active' => $this->getAttribute('user.not_active')]);

        return $dataProvider;
    }
}
