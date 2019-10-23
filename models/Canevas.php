<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "canevas".
 *
 * @property int $id
 * @property string $nom
 * @property string $description
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
}
