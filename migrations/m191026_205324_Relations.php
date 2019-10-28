<?php

use yii\db\Schema;
use yii\db\Migration;

class m191026_205324_Relations extends Migration
{

    public function init()
    {
       $this->db = 'db';
       parent::init();
    }

    public function safeUp()
    {
        $this->addForeignKey('fk_Exercice_canevas_id',
            '{{%Exercice}}','canevas_id',
            '{{%Canevas}}','id',
            'CASCADE','CASCADE'
         );
        $this->addForeignKey('fk_Exercice_rapport_id',
            '{{%Exercice}}','rapport_id',
            '{{%Rapport}}','id',
            'CASCADE','CASCADE'
         );
        $this->addForeignKey('fk_Exercice_unite_id',
            '{{%Exercice}}','unite_id',
            '{{%Unite}}','id',
            'CASCADE','CASCADE'
         );
        $this->addForeignKey('fk_Indicateur_canvevas_id',
            '{{%Indicateur}}','canvevas_id',
            '{{%Canevas}}','id',
            'CASCADE','CASCADE'
         );
        $this->addForeignKey('fk_Realisation_indicateur_id',
            '{{%Realisation}}','mesure_id',
            '{{%Indicateur}}','id',
            'CASCADE','CASCADE'
         );
        $this->addForeignKey('fk_Realisation_exercice_id',
            '{{%Realisation}}','exercice_id',
            '{{%Exercice}}','id',
            'CASCADE','CASCADE'
         );
        $this->addForeignKey('fk_Realisation_utilisateur_id',
            '{{%Realisation}}','utilisateur_id',
            '{{%Utilisateur}}','id',
            'CASCADE','CASCADE'
         );
        $this->addForeignKey('fk_Utilisateur_unite_id',
            '{{%Utilisateur}}','unite_id',
            '{{%Unite}}','id',
            'CASCADE','CASCADE'
         );
        $this->addForeignKey('fk_Utilisateur_user_id',
            '{{%Utilisateur}}','user_id',
            '{{%user}}','id',
            'CASCADE','CASCADE'
         );        
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_Exercice_canevas_id', '{{%Exercice}}');
        $this->dropForeignKey('fk_Exercice_rapport_id', '{{%Exercice}}');
        $this->dropForeignKey('fk_Exercice_unite_id', '{{%Exercice}}');
        $this->dropForeignKey('fk_Indicateur_canvevas_id', '{{%Indicateur}}');
        $this->dropForeignKey('fk_Realisation_indicateur_id', '{{%Realisation}}');
        $this->dropForeignKey('fk_Realisation_exercice_id', '{{%Realisation}}');
        $this->dropForeignKey('fk_Realisation_utilisateur_id', '{{%Realisation}}');
        $this->dropForeignKey('fk_Utilisateur_unite_id', '{{%Utilisateur}}');
        $this->dropForeignKey('fk_Utilisateur_user_id', '{{%Utilisateur}}');
        
    }
}
