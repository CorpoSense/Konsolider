<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "utilisateur".
 *
 * @property int $id
 * @property string $nom
 * @property string $prenom
 * @property int $unite_id
 *
 * @property Realisation[] $realisations
 * @property Unite $unite
 */
class Utilisateur extends \yii\db\ActiveRecord
{
    
//    public $id;
//    public $nom;
//    public $prenom;

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
            [['nom', 'unite_id', 'user_id'], 'required'],
            [['unite_id', 'user_id'], 'integer'],
            [['nom', 'prenom'], 'string', 'max' => 255],
            [['unite_id'], 'exist', 'skipOnError' => true, 'targetClass' => Unite::className(), 'targetAttribute' => ['unite_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
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
            'unite_id' => 'Unite ID',
            'user_id' => 'User ID',
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
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }
 
}
