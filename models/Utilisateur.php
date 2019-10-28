<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "utilisateur".
 *
 * @property int $id
 * @property string $nom
 * @property string $role
 * @property string $authKey
 * @property string $accessToken
 * @property int $unite_id
 *
 * @property Realisation[] $realisations
 * @property Unite $unite
 */
class Utilisateur extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    
//    public $id;
//    public $nom;
//    public $password;
//    public $role;
//    public $authKey;
//    public $accessToken;

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


    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return self::findOne(['id' => $id]);
//        return isset(self::$users[$id]) ? new static(self::$users[$id]) : null;
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return self::findOne(['access_token' => $token]);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return self::findOne(['nom' => $username]);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === Yii::$app->security->validatePassword($password, $this->authKey);
    }
    
    public function isAdmin()
    {
      // return Yii::$app->user->id == 1;
      return $this->id == 1;
    }    
}
