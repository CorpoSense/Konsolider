<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "exercice".
 *
 * @property int $id
 * @property string $canevas_id
 * @property string $rapport_id
 * @property string $unite_id
 */
class Exercice extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'exercice';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['canevas_id', 'rapport_id', 'unite_id'], 'required'],
            [['canevas_id', 'rapport_id', 'unite_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'canevas_id' => 'Canevas ID',
            'rapport_id' => 'Rapport ID',
            'unite_id' => 'Unite ID',
        ];
    }
}
