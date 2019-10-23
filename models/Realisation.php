<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "realisation".
 *
 * @property int $id
 * @property string $prevue
 * @property string $realise
 * @property string $mesure_id
 * @property string $exercice_id
 * @property string $utilisateur_id
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
}
