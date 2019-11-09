<?php

use yii\db\Schema;
use yii\db\Migration;

class m191109_104103_rapport extends Migration
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
            '{{%rapport}}',
            [
                'id'=> $this->primaryKey(11),
                'nom'=> $this->string(255)->notNull(),
                'debut'=> $this->date()->notNull(),
                'fin'=> $this->date()->notNull(),
            ],$tableOptions
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%rapport}}');
    }
}
