<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Indicateur;

/**
 * IndicateurSearch represents the model behind the search form of `app\models\Indicateur`.
 */
class IndicateurSearch extends Indicateur
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'nom', 'description', 'requis', 'canvevas_id'], 'integer'],
            [['type', 'unite_mesure'], 'safe'],
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
        $query = Indicateur::find();

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
            'nom' => $this->nom,
            'description' => $this->description,
            'requis' => $this->requis,
            'canvevas_id' => $this->canvevas_id,
        ]);

        $query->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'unite_mesure', $this->unite_mesure]);

        return $dataProvider;
    }
}
