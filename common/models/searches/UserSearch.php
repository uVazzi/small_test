<?php

namespace common\models\searches;

use common\models\enums\StatusEnum;
use yii\base\Model;
use common\models\domains\User;
use yii\data\ArrayDataProvider;

/**
 * UserSearch represents the model behind the search form of `common\models\domains\User`.
 */
class UserSearch extends User
{
    public $moreSeven;
    public  $lessSeven;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'rating', 'create_at', 'status_id'], 'integer'],
            [['name', 'surname', 'email', 'phone_number'], 'safe'],
            [['moreSeven', 'lessSeven'], 'safe']
        ];
    }

    /**
     * {@inheritdoc}
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
     * @return ArrayDataProvider
     */
    public function search($params)
    {
        $query = User::find()
            ->orderBy(['id' => SORT_ASC])
            ->limit(10)
            ->joinWith(['status'])
            ->andWhere(['status_name' => [StatusEnum::APPROVED, StatusEnum::SPECIAL]]);

        $dataProvider = new ArrayDataProvider(
            [
                'allModels' => $query->all()
            ]
        );

        $dataProvider->setSort([
            'attributes' => [
                'name',
                'surname',
                'moreSeven',
                'lessSeven',
            ],
            'defaultOrder' => [
                'moreSeven' => SORT_DESC,
                'lessSeven' => SORT_DESC,
            ]
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
            'rating' => $this->rating,
            'create_at' => $this->create_at,
            'status_id' => $this->status_id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'surname', $this->surname])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'phone_number', $this->phone_number]);

        return $dataProvider;
    }
}
