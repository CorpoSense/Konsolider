<?php

use yii\db\Schema;
use yii\db\Migration;

class m191109_104101_exercice extends Migration
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
            '{{%exercice}}',
            [
                'id'=> $this->primaryKey(11),
                'canevas_id'=> $this->integer(11)->notNull(),
                'rapport_id'=> $this->integer(11)->notNull(),
                'unite_id'=> $this->integer(11)->notNull(),
            ],$tableOptions
        );
        $this->createIndex('unique_row','{{%exercice}}',['canevas_id','rapport_id','unite_id'],true);
        $this->createIndex('Exercice_fk1','{{%exercice}}',['rapport_id'],false);
        $this->createIndex('Exercice_fk2','{{%exercice}}',['unite_id'],false);

    }

    public function safeDown()
    {
        $this->dropIndex('unique_row', '{{%exercice}}');
        $this->dropIndex('Exercice_fk1', '{{%exercice}}');
        $this->dropIndex('Exercice_fk2', '{{%exercice}}');
        $this->dropTable('{{%exercice}}');
    }
}
