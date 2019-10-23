<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Utilisateur;

/**
 * UtilisateurSearch represents the model behind the search form of `app\models\Utilisateur`.
 */
class UtilisateurSearch extends Utilisateur
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'Unite_id'], 'integer'],
            [['nom', 'prenom', 'role'], 'safe'],
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
        $query = Utilisateur::find();

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
            'Unite_id' => $this->Unite_id,
        ]);

        $query->andFilterWhere(['like', 'nom', $this->nom])
            ->andFilterWhere(['like', 'prenom', $this->prenom])
            ->andFilterWhere(['like', 'role', $this->role]);

        return $dataProvider;
    }
}
