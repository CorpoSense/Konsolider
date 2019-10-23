<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "utilisateur".
 *
 * @property int $id
 * @property string $nom
 * @property string $prenom
 * @property string $role
 * @property int $unite_id
 *
 * @property Realisation[] $realisations
 * @property Unite $unite
 */
class Utilisateur extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'utilisateur';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nom', 'prenom', 'role', 'unite_id'], 'required'],
            [['unite_id'], 'integer'],
            [['nom', 'prenom', 'role'], 'string', 'max' => 255],
            [['unite_id'], 'exist', 'skipOnError' => true, 'targetClass' => Unite::className(), 'targetAttribute' => ['unite_id' => 'id']],
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
            'prenom' => 'Prenom',
            'role' => 'Role',
            'unite_id' => 'Unite ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRealisations()
    {
        return $this->hasMany(Realisation::className(), ['utilisateur_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnite()
    {
        return $this->hasOne(Unite::className(), ['id' => 'unite_id']);
    }
}
