<?php

use yii\db\Schema;
use yii\db\Migration;

class m191026_205320_Rapport extends Migration
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
            '{{%Rapport}}',
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
        $this->dropTable('{{%Rapport}}');
    }
}
