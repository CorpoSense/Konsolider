<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "indicateur".
 *
 * @property int $id
 * @property string $nom
 * @property string $description
 * @property string $type
 * @property string $unite_mesure
 * @property int $requis
 * @property int $canvevas_id
 *
 * @property Canevas $canvevas
 * @property Realisation[] $realisations
 */
class Indicateur extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'indicateur';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nom', 'description', 'type', 'unite_mesure', 'requis', 'canvevas_id'], 'required'],
            [['description'], 'string'],
            [['requis', 'canvevas_id'], 'integer'],
            [['nom', 'type', 'unite_mesure'], 'string', 'max' => 255],
            [['canvevas_id'], 'exist', 'skipOnError' => true, 'targetClass' => Canevas::className(), 'targetAttribute' => ['canvevas_id' => 'id']],
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
            'type' => 'Type',
            'unite_mesure' => 'Unite Mesure',
            'requis' => 'Requis',
            'canvevas_id' => 'Canvevas',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCanvevas()
    {
        return $this->hasOne(Canevas::className(), ['id' => 'canvevas_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRealisations()
    {
        return $this->hasMany(Realisation::className(), ['mesure_id' => 'id']);
    }

    public function getRequis()
    {
      return $this->requis === 1? 'Oui':'Non';
    }
}
