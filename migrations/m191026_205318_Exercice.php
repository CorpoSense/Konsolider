<?php

use yii\db\Schema;
use yii\db\Migration;

class m191026_205318_Exercice extends Migration
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
            '{{%Exercice}}',
            [
                'id'=> $this->primaryKey(11),
                'canevas_id'=> $this->integer(11)->notNull(),
                'rapport_id'=> $this->integer(11)->notNull(),
                'unite_id'=> $this->integer(11)->notNull(),
            ],$tableOptions
        );
        $this->createIndex('unique_row','{{%Exercice}}',['canevas_id','rapport_id','unite_id'],true);
        $this->createIndex('Exercice_fk0','{{%Exercice}}',['canevas_id'],false);
        $this->createIndex('Exercice_fk1','{{%Exercice}}',['rapport_id'],false);
        $this->createIndex('Exercice_fk2','{{%Exercice}}',['unite_id'],false);

    }

    public function safeDown()
    {
        $this->dropIndex('unique_row', '{{%Exercice}}');        
        $this->dropIndex('Exercice_fk0', '{{%Exercice}}');
        $this->dropIndex('Exercice_fk1', '{{%Exercice}}');
        $this->dropIndex('Exercice_fk2', '{{%Exercice}}');
        $this->dropTable('{{%Exercice}}');
    }
}
