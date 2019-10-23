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
 * @property string $canvevas_id
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
            [['nom', 'description', 'requis', 'canvevas_id'], 'integer'],
            [['type', 'unite_mesure'], 'string', 'max' => 255],
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
            'canvevas_id' => 'Canvevas ID',
        ];
    }
}
