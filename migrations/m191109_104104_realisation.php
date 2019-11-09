<?php

use yii\db\Schema;
use yii\db\Migration;

class m191109_104104_realisation extends Migration
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
            '{{%realisation}}',
            [
                'id'=> $this->primaryKey(11),
                'prevue'=> $this->decimal(10)->notNull(),
                'realise'=> $this->decimal(10)->notNull(),
                'indicateur_id'=> $this->integer(11)->notNull(),
                'exercice_id'=> $this->integer(11)->notNull(),
                'utilisateur_id'=> $this->integer(11)->notNull(),
                'etat'=> $this->integer(11)->notNull(),
            ],$tableOptions
        );
        $this->createIndex('Realisation_fk1','{{%realisation}}',['exercice_id'],false);
        $this->createIndex('Realisation_fk2','{{%realisation}}',['utilisateur_id'],false);
        $this->createIndex('Realisation_fk0','{{%realisation}}',['indicateur_id'],false);

    }

    public function safeDown()
    {
        $this->dropIndex('Realisation_fk1', '{{%realisation}}');
        $this->dropIndex('Realisation_fk2', '{{%realisation}}');
        $this->dropIndex('Realisation_fk0', '{{%realisation}}');
        $this->dropTable('{{%realisation}}');
    }
}
