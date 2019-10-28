<?php

use yii\db\Schema;
use yii\db\Migration;

class m191026_205323_Utilisateur extends Migration
{

    public function init()
    {
        $this->db = 'db';
        parent::init();
    }

    public function safeUp()
    {
        $tableOptions = 'ENGINE=InnoDB';

        $this->createTable(
            '{{%Utilisateur}}',
            [
                'id'=> $this->primaryKey(11),
                'nom'=> $this->string(255)->notNull(),
                'prenom'=> $this->string(250)->notNull(),
                'unite_id'=> $this->integer(11)->notNull(),
            ],$tableOptions
        );
        $this->createIndex('Utilisateur_fk0','{{%Utilisateur}}',['unite_id'],false);

    }

    public function safeDown()
    {
        $this->dropIndex('Utilisateur_fk0', '{{%Utilisateur}}');
        $this->dropTable('{{%Utilisateur}}');
    }
}
