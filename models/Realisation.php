<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "realisation".
 *
 * @property int $id
 * @property string $prevue
 * @property string $realise
 * @property int $mesure_id
 * @property int $exercice_id
 * @property int $utilisateur_id
 *
 * @property Indicateur $mesure
 * @property Exercice $exercice
 * @property Utilisateur $utilisateur
 */
class Realisation extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'realisation';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['prevue', 'realise', 'mesure_id', 'exercice_id', 'utilisateur_id'], 'required'],
            [['prevue', 'realise'], 'number'],
            [['mesure_id', 'exercice_id', 'utilisateur_id'], 'integer'],
            [['mesure_id'], 'exist', 'skipOnError' => true, 'targetClass' => Indicateur::className(), 'targetAttribute' => ['mesure_id' => 'id']],
            [['exercice_id'], 'exist', 'skipOnError' => true, 'targetClass' => Exercice::className(), 'targetAttribute' => ['exercice_id' => 'id']],
            [['utilisateur_id'], 'exist', 'skipOnError' => true, 'targetClass' => Utilisateur::className(), 'targetAttribute' => ['utilisateur_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'prevue' => 'Prevue',
            'realise' => 'Realise',
            'mesure_id' => 'Mesure ID',
            'exercice_id' => 'Exercice ID',
            'utilisateur_id' => 'Utilisateur ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMesure()
    {
        return $this->hasOne(Indicateur::className(), ['id' => 'mesure_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExercice()
    {
        return $this->hasOne(Exercice::className(), ['id' => 'exercice_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUtilisateur()
    {
        return $this->hasOne(Utilisateur::className(), ['id' => 'utilisateur_id']);
    }
}
