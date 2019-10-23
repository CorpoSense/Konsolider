<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "canevas".
 *
 * @property int $id
 * @property string $nom
 * @property string $description
 *
 * @property Exercice[] $exercices
 * @property Indicateur[] $indicateurs
 */
class Canevas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'canevas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nom', 'description'], 'required'],
            [['nom', 'description'], 'string', 'max' => 255],
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
            'description' => 'Description',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExercices()
    {
        return $this->hasMany(Exercice::className(), ['canevas_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIndicateurs()
    {
        return $this->hasMany(Indicateur::className(), ['canvevas_id' => 'id']);
    }
}
