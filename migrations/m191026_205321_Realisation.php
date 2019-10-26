<?php

use yii\db\Schema;
use yii\db\Migration;

class m191026_205321_Realisation extends Migration
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
            '{{%Realisation}}',
            [
                'id'=> $this->primaryKey(11),
                'prevue'=> $this->decimal(10)->notNull(),
                'realise'=> $this->decimal(10)->notNull(),
                'mesure_id'=> $this->integer(11)->notNull(),
                'exercice_id'=> $this->integer(11)->notNull(),
                'utilisateur_id'=> $this->integer(11)->notNull(),
            ],$tableOptions
        );
        $this->createIndex('Realisation_fk0','{{%Realisation}}',['mesure_id'],false);
        $this->createIndex('Realisation_fk1','{{%Realisation}}',['exercice_id'],false);
        $this->createIndex('Realisation_fk2','{{%Realisation}}',['utilisateur_id'],false);

    }

    public function safeDown()
    {
        $this->dropIndex('Realisation_fk0', '{{%Realisation}}');
        $this->dropIndex('Realisation_fk1', '{{%Realisation}}');
        $this->dropIndex('Realisation_fk2', '{{%Realisation}}');
        $this->dropTable('{{%Realisation}}');
    }
}
