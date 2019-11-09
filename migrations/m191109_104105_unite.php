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
                'nom'=> $this->string(255)->notNull(),
                'responsable'=> $this->string(255)->notNull(),
            ],$tableOptions
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%unite}}');
    }
}
