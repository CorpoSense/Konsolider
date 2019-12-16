<?php

namespace app\models;

use yii\base\Model;

/**
 * FilterForm is the model behind the filter form.
 */
class FilterForm extends Model
{
    
    public $unite_id;
    public $rapport_id;
    public $canevas_id;
    
    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['unite_id', 'rapport_id', 'canevas_id'], 'integer']
            ];
    }
    
    public function attributeLabels() {
        return [
            'unite_id' => 'Unité',
            'rapport_id' => 'Rapport',
            'canevas_id' => 'Canevas'
        ];
    }

}