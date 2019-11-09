<?php

use yii\db\Schema;
use yii\db\Migration;

class m191109_104102_indicateur extends Migration
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
            '{{%indicateur}}',
            [
                'id'=> $this->primaryKey(11),
                'nom'=> $this->string(255)->notNull(),
                'description'=> $this->text()->notNull(),
                'type'=> $this->string(255)->notNull(),
                'unite_mesure'=> $this->string(255)->notNull(),
                'requis'=> $this->tinyInteger(1)->notNull(),
                'canvevas_id'=> $this->integer(11)->notNull(),
            ],$tableOptions
        );
        $this->createIndex('Indicateur_fk0','{{%indicateur}}',['canvevas_id'],false);

    }

    public function safeDown()
    {
        $this->dropIndex('Indicateur_fk0', '{{%indicateur}}');
        $this->dropTable('{{%indicateur}}');
    }
}
