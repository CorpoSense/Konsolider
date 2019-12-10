<?php

use yii\db\Schema;
use yii\db\Migration;

class m191109_104105_unite extends Migration
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
            '{{%unite}}',
            [
                'id'=> $this->primaryKey(11),
                'nom'=> $this->string(255)->notNull()->unique(),
                'responsable'=> $this->string(255)->notNull(),
            ],$tableOptions
        );
        $this->createIndex('idx_nom_unique','{{%Unite}}',['nom'],true);

    }

    public function safeDown()
    {
        $this->dropIndex('idx_nom_unique', '{{%Unite}}');
        $this->dropTable('{{%unite}}');
    }
}
