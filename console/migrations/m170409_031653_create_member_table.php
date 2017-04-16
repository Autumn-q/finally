<?php

use yii\db\Migration;

/**
 * Handles the creation of table `member`.
 */
class m170409_031653_create_member_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('member', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull(),
            'auth_key' => $this->string(32),
            'password' => $this->string()->notNull(),
            'email' => $this->string()->notNull()->unique(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'tel'=>$this->string(11)->notNull(),
            'created_add' => $this->integer(),
            'updated_at' => $this->integer(),
            'last_login_time' => $this->integer()->notNull(),
            'last_login_ip' => $this->integer()->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('member');
    }
}
