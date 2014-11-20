<?php

use yii\db\Schema;

class m140527_070146_users_init extends \yii\db\Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%users}}', [
            'id' => Schema::TYPE_PK,
            'nickname' => Schema::TYPE_STRING . '(64) NOT NULL',
            'username' => Schema::TYPE_STRING . ' NOT NULL',
            'email' => Schema::TYPE_STRING . ' NOT NULL',
            'auth_key' => Schema::TYPE_STRING . '(32) NOT NULL',
            'password_hash' => Schema::TYPE_STRING . ' NOT NULL',
            'password_reset_token' => Schema::TYPE_STRING,
            'status' => Schema::TYPE_SMALLINT . ' NOT NULL',

            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);

        // Create indexes
        $this->createIndex('username', '{{%users}}', 'username', true);
        $this->createIndex('email', '{{%users}}', 'email', true);
        $this->createIndex('status', '{{%users}}', 'status');

        // Create user admin
        $this->execute($this->getSql());
    }

    public function down()
    {
        $this->dropTable('{{%user}}');
    }

    private function getSql()
    {
        $time = time();
        $password_hash = Yii::$app->getSecurity()->generatePasswordHash('admin88');
        $auth_key = Yii::$app->getSecurity()->generateRandomString();
        return "INSERT INTO {{%users}} (`nickname`, `username`, `email`, `auth_key`, `password_hash`, `password_reset_token`, `status`, `created_at`, `updated_at`)
                VALUES ('Jroy', 'admin', 'admin@demo.com', '$auth_key', '$password_hash', '', 1, $time, $time)";
    }
}
