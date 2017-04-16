<?php

use yii\db\Migration;

/**
 * Handles the creation of table `address`.
 */
class m170409_071554_create_address_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('address', [
            'id' => $this->primaryKey(),
            'name'=>$this->string(20)->notNull()->comment('收货人'),
            'province'=>$this->string(10)->notNull()->comment('省份'),
            'city'=>$this->string(10)->notNull()->comment('城市'),
            'area'=>$this->string(10)->notNull()->comment('乡县'),
            'address'=>$this->string(255)->notNull()->comment('收货地址'),
            'member_id'=>$this->integer()->comment('所属用户'),
            'tel'=>$this->string(11)->comment('手机号'),
            'status'=>$this->integer()->comment('状态'),
            'create_add'=>$this->integer()->comment('添加时间'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('address');
    }
}
