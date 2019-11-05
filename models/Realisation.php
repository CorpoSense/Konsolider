<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Realisation".
 *
 * @property int $id
 * @property string $prevue
 * @property string $realise
 * @property int $indicateur_id
 * @property int $exercice_id
 * @property int $utilisateur_id
 * @property int $etat
 *
 * @property Indicateur $indicateur
 * @property Exercice $exercice
 * @property Utilisateur $utilisateur
 */
class Realisation extends \yii\db\ActiveRecord
{
    
    const ETAT_NONVALID = 0;
    const ETAT_VALID = 1;
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Realisation';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['prevue', 'realise', 'indicateur_id', 'exercice_id', 'utilisateur_id', 'etat'], 'required'],
            [['prevue', 'realise'], 'number'],
            [['indicateur_id', 'exercice_id', 'utilisateur_id', 'etat'], 'integer'],
            [['indicateur_id'], 'exist', 'skipOnError' => true, 'targetClass' => Indicateur::className(), 'targetAttribute' => ['indicateur_id' => 'id']],
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
            'indicateur_id' => 'Indicateur',
            'exercice_id' => 'Exercice',
            'utilisateur_id' => 'Utilisateur',
            'etat' => 'Etat',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIndicateur()
    {
        return $this->hasOne(Indicateur::className(), ['id' => 'indicateur_id']);
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
    
    public function getEtat() {
        return $this->etat == self::ETAT_VALID?'Validé': 'Non Validé';
    }
    
    public static function hasExercice($exercice_id) {
        return (!empty(self::find()->where(['exercice_id' => $exercice_id])->one()));
    }
}
