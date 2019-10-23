<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "rapport".
 *
 * @property int $id
 * @property string $nom
 * @property string $debut
 * @property string $fin
 *
 * @property Exercice[] $exercices
 */
class Rapport extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rapport';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nom', 'debut', 'fin'], 'required'],
            [['debut', 'fin'], 'safe'],
            [['nom'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nom' => 'Nom',
            'debut' => 'Debut',
            'fin' => 'Fin',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExercices()
    {
        return $this->hasMany(Exercice::className(), ['rapport_id' => 'id']);
    }
}
