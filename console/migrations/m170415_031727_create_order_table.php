<?php

use yii\db\Migration;

/**
 * Handles the creation of table `order`.
 */
class m170415_031727_create_order_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('order', [
            'id' => $this->primaryKey(),
            'member_id'=>$this->integer(11)->notNull()->comment('会员id'),
            'name'=>$this->string(20)->notNull()->comment('收货人'),
            'province'=>$this->string(30)->notNull()->comment('省份'),
            'city'=>$this->string(30)->notNull()->comment('城市'),
            'area'=>$this->string(30)->notNull()->comment('区县'),
            'address'=>$this->string(40)->notNull()->comment('详细地址'),
            'tel'=>$this->string(11)->notNull()->comment('手机号'),
            'delivery_id'=>$this->integer(3)->notNull()->comment('配送方式id'),
            'delivery_name'=>$this->string(30)->notNull()->comment('配送方式名字'),
            'delivery_price'=>$this->decimal(7.2)->notNull()->comment('配送费'),
            'pay_type_id'=>$this->integer(3)->notNull()->comment('支付方式id'),
            'pay_type_name'=>$this->string(30)->notNull()->comment('支付方式名字'),
            'price'=>$this->decimal(10,2)->notNull()->comment('商品价格'),
            'status'=>$this->integer()->notNull()->comment('订单状态'),
            'trade_no'=>$this->string(30)->notNull()->comment('第三方交易方式'),
            'create_time'=>$this->integer()->notNull()->comment('创建时间'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('order');
    }
}
