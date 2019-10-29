<?php

use yii\db\Schema;
use yii\db\Migration;

class m191028_132504_user extends Migration
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
            '{{%user}}',
            [
                'id'=> $this->primaryKey(11),
                'username'=> $this->string(80)->notNull(),
                'password'=> $this->string(255)->notNull(),
                'auth_key'=> $this->string(255)->notNull(),
                'access_token'=> $this->string(255)->notNull(),
                'role'=> $this->integer(1)->notNull()->defaultValue(0),
                'status'=> $this->integer(1)->notNull()->defaultValue(1),
            ],$tableOptions
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%user}}');
    }
}
