<?php

namespace core\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use core\models\RegistryBusinessApprovalLog;

/**
 * RegistryBusinessApprovalLogSearch represents the model behind the search form of `core\models\RegistryBusinessApprovalLog`.
 */
class RegistryBusinessApprovalLogSearch extends RegistryBusinessApprovalLog
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['registry_business_id', 'business_id', 'user_created', 'user_updated'], 'integer'],
            [['membership_type_id', 'status', 'created_at', 'updated_at'], 'safe'],
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
        $query = RegistryBusinessApprovalLog::find();

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
            'registry_business_id' => $this->registry_business_id,
            'business_id' => $this->business_id,
            'created_at' => $this->created_at,
            'user_created' => $this->user_created,
            'updated_at' => $this->updated_at,
            'user_updated' => $this->user_updated,
        ]);

        $query->andFilterWhere(['ilike', 'membership_type_id', $this->membership_type_id])
            ->andFilterWhere(['ilike', 'status', $this->status]);

        return $dataProvider;
    }
}
