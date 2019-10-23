<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Realisation;

/**
 * RealisationSearch represents the model behind the search form of `app\models\Realisation`.
 */
class RealisationSearch extends Realisation
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'mesure_id', 'exercice_id', 'utilisateur_id'], 'integer'],
            [['prevue', 'realise'], 'number'],
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
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Realisation::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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
            'prevue' => $this->prevue,
            'realise' => $this->realise,
            'mesure_id' => $this->mesure_id,
            'exercice_id' => $this->exercice_id,
            'utilisateur_id' => $this->utilisateur_id,
        ]);

        return $dataProvider;
    }
}
