<?php

namespace app\models;
use yii\behaviors\TimestampBehavior;
use Yii;

/**
 * This is the model class for table "unite".
 *
 * @property int $unite_id
 * @property string $nom
 * @property string $responsable
 * @property string $created_at
 * @property string $updated_at
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
            [['nom', 'responsable' , 'created_at', 'updated_at'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['nom', 'responsable'], 'string', 'max' => 250],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'unite_id' => 'Unite ID',
            'nom' => 'Nom',
            'responsable' => 'Responsable',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
    public function behaviors()
{
    return [
        TimestampBehavior::className(),
    ];
}
}
