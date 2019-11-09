<?php

use yii\db\Schema;
use yii\db\Migration;

class m191109_104100_canevas extends Migration
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
            '{{%canevas}}',
            [
                'id'=> $this->primaryKey(11),
                'nom'=> $this->string(255)->notNull(),
                'description'=> $this->string(255)->notNull(),
            ],$tableOptions
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%canevas}}');
    }
}
