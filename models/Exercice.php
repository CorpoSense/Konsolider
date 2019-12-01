<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "exercice".
 *
 * @property int $id
 * @property int $canevas_id
 * @property int $rapport_id
 * @property int $unite_id
 *
 * @property Canevas $canevas
 * @property Rapport $rapport
 * @property Unite $unite
 * @property Realisation[] $realisations
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
            [['canevas_id'], 'exist', 'skipOnError' => true, 'targetClass' => Canevas::className(), 'targetAttribute' => ['canevas_id' => 'id']],
            [['rapport_id'], 'exist', 'skipOnError' => true, 'targetClass' => Rapport::className(), 'targetAttribute' => ['rapport_id' => 'id']],
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
            'canevas_id' => 'Canevas',
            'rapport_id' => 'Rapport',
            'unite_id' => 'Unite',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCanevas()
    {
        return $this->hasOne(Canevas::className(), ['id' => 'canevas_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRapport()
    {
        return $this->hasOne(Rapport::className(), ['id' => 'rapport_id']);
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
    public function getRealisations()
    {
        return $this->hasMany(Realisation::className(), ['exercice_id' => 'id']);
    }
    
    public function getProgression() {
        $realisations = Realisation::find(['exercice_id' => $this->id])->all();
        $total = 0;
        $valide = 0;
        foreach ($realisations as $realisation) {
            if ($realisation->exercice->canevas_id == $this->canevas_id && $realisation->exercice->unite_id == $this->unite_id){
                if ($realisation->etat == Realisation::ETAT_VALID){
                    $valide += 1;
                }
                $total += 1;
            }
        }
        return ($total > 0? ($valide*100/$total):0 );
    }
}
