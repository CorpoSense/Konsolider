<?php

use yii\db\Schema;
use yii\db\Migration;

class m191109_104107_utilisateur extends Migration
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
            '{{%utilisateur}}',
            [
                'id'=> $this->primaryKey(11),
                'nom'=> $this->string(255)->notNull(),
                'prenom'=> $this->string(255)->null()->defaultValue(null),
                'unite_id'=> $this->integer(11)->notNull(),
                'user_id'=> $this->integer(11)->notNull(),
            ],$tableOptions
        );
        $this->createIndex('Utilisateur_fk0','{{%utilisateur}}',['unite_id'],false);
        $this->createIndex('Utilisateur_fk1','{{%utilisateur}}',['user_id'],false);

    }

    public function safeDown()
    {
        $this->dropIndex('Utilisateur_fk0', '{{%utilisateur}}');
        $this->dropIndex('Utilisateur_fk1', '{{%utilisateur}}');
        $this->dropTable('{{%utilisateur}}');
    }
}
