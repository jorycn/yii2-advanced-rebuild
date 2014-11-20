<?php

use yii\db\Schema;
use yii\i18n\DbMessageSource;

class m140604_152952_i18n_init extends \yii\db\Migration
{
    public function up()
    {
        $dbMessage = new DbMessageSource();
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable($dbMessage->sourceMessageTable, [
            'id' => Schema::TYPE_PK,
            'category' => Schema::TYPE_STRING . '(32) NOT NULL',
            'message' => Schema::TYPE_TEXT,
        ], $tableOptions);

        $this->createTable($dbMessage->messageTable, [
            'id' => Schema::TYPE_INTEGER,
            'language' => Schema::TYPE_STRING . '(16) NOT NULL',
            'translation' => Schema::TYPE_TEXT,
            'PRIMARY KEY (id, language)',
            'CONSTRAINT fk_message_source_message FOREIGN KEY (id)
                    REFERENCES ' . $dbMessage->sourceMessageTable . ' (id) ON DELETE CASCADE ON UPDATE RESTRICT',
        ], $tableOptions);
    }

    public function down()
    {
        $dbMessage = new DbMessageSource();
        $this->dropTable($dbMessage->messageTable);
        $this->dropTable($dbMessage->sourceMessageTable);
    }
}
