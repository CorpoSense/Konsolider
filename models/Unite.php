<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "unite".
 *
 * @property int $id
 * @property string $nom
 * @property string $responsable
 *
 * @property Exercice[] $exercices
 * @property Utilisateur[] $utilisateurs
 */
class Unite extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'unite';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nom', 'responsable'], 'required'],
            [['nom', 'responsable'], 'string', 'max' => 255],
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
            'responsable' => 'Responsable',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExercices()
    {
        return $this->hasMany(Exercice::className(), ['unite_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUtilisateurs()
    {
        return $this->hasMany(Utilisateur::className(), ['unite_id' => 'id']);
    }
}
