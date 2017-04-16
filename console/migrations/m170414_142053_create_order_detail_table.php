<?php

use yii\db\Migration;

/**
 * Handles the creation of table `order_detail`.
 */
class m170414_142053_create_order_detail_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('order_detail', [
            'id' => $this->primaryKey(),
            'order_info_id'=>$this->integer()->comment('订单id'),
            'goods_id'=>$this->integer()->comment('商品id'),
            'goods_name'=>$this->string(40)->comment('商品名称'),
            'logo'=>$this->string(255)->comment('logo'),
            'price'=>$this->decimal(10,2)->comment('价格'),
            'amount'=>$this->integer(10)->comment('数量'),
            'total_price'=>$this->decimal(10,2)->comment('小计'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('order_detail');
    }
}
