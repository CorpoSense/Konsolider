<?php

use yii\db\Schema;
use yii\db\Migration;

class m191109_104108_Relations extends Migration
{

    public function init()
    {
       $this->db = 'db';
       parent::init();
    }

    public function safeUp()
    {
        $this->addForeignKey('fk_exercice_canevas_id',
            '{{%exercice}}','canevas_id',
            '{{%canevas}}','id',
            'CASCADE','CASCADE'
         );
        $this->addForeignKey('fk_exercice_rapport_id',
            '{{%exercice}}','rapport_id',
            '{{%rapport}}','id',
            'CASCADE','CASCADE'
         );
        $this->addForeignKey('fk_exercice_unite_id',
            '{{%exercice}}','unite_id',
            '{{%unite}}','id',
            'CASCADE','CASCADE'
         );
        $this->addForeignKey('fk_indicateur_canvevas_id',
            '{{%indicateur}}','canvevas_id',
            '{{%canevas}}','id',
            'CASCADE','CASCADE'
         );
        $this->addForeignKey('fk_realisation_indicateur_id',
            '{{%realisation}}','indicateur_id',
            '{{%indicateur}}','id',
            'CASCADE','CASCADE'
         );
        $this->addForeignKey('fk_realisation_exercice_id',
            '{{%realisation}}','exercice_id',
            '{{%exercice}}','id',
            'CASCADE','CASCADE'
         );
        $this->addForeignKey('fk_realisation_utilisateur_id',
            '{{%realisation}}','utilisateur_id',
            '{{%utilisateur}}','id',
            'CASCADE','CASCADE'
         );
        $this->addForeignKey('fk_utilisateur_unite_id',
            '{{%utilisateur}}','unite_id',
            '{{%unite}}','id',
            'CASCADE','CASCADE'
         );
        $this->addForeignKey('fk_utilisateur_user_id',
            '{{%utilisateur}}','user_id',
            '{{%user}}','id',
            'CASCADE','CASCADE'
         );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_exercice_canevas_id', '{{%exercice}}');
        $this->dropForeignKey('fk_exercice_rapport_id', '{{%exercice}}');
        $this->dropForeignKey('fk_exercice_unite_id', '{{%exercice}}');
        $this->dropForeignKey('fk_indicateur_canvevas_id', '{{%indicateur}}');
        $this->dropForeignKey('fk_realisation_indicateur_id', '{{%realisation}}');
        $this->dropForeignKey('fk_realisation_exercice_id', '{{%realisation}}');
        $this->dropForeignKey('fk_realisation_utilisateur_id', '{{%realisation}}');
        $this->dropForeignKey('fk_utilisateur_unite_id', '{{%utilisateur}}');
        $this->dropForeignKey('fk_utilisateur_user_id', '{{%utilisateur}}');
    }
}
