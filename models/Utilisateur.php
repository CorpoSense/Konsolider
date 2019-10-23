<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "utilsateur".
 *
 * @property int $id
 * @property string $nom
 * @property string $prenom
 * @property string $role
 * @property string $Unite_id
 */
class Utilisateur extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'utilsateur';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nom', 'prenom', 'role', 'Unite_id'], 'required'],
            [['Unite_id'], 'integer'],
            [['nom', 'prenom', 'role'], 'string', 'max' => 255],
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
            'Unite_id' => 'Unite ID',
        ];
    }
}
