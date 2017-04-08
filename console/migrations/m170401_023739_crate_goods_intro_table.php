<?php

use yii\db\Migration;

class m170401_023739_crate_goods_intro_table extends Migration
{
    public function up()
    {
        $this->createTable('goods_intro', [
            'goods_id' => $this->integer()->notNull()->comment('商品id'),
            'content'=>$this->text()->comment('商品描述'),
        ]);
    }

    public function down()
    {
        echo "m170401_023739_crate_goods_intro_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
