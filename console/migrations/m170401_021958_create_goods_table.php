<?php

use yii\db\Migration;

/**
 * Handles the creation of table `goods`.
 */
class m170401_021958_create_goods_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('goods', [
            'id' => $this->primaryKey(),
            'name'=>$this->string(50)->notNull()->comment('商品名'),
            'sn'=>$this->string(50)->notNull()->comment('货号'),
            'logo'=>$this->string(100)->notNull()->comment('logo'),
            'goods_category_id'=>$this->integer()->notNull()->defaultValue(0)->comment('商品分类id'),
            'brand_id'=>$this->integer()->notNull()->defaultValue(0)->comment('品牌id'),
            'market_price'=>$this->decimal(10,2)->notNull()->defaultValue(0.00)->comment('市场售价'),
            'shop_price'=>$this->decimal(10,2)->notNull()->defaultValue(0.00)->comment('本店售价'),
            'stock'=>$this->integer()->notNull()->defaultValue(0)->comment('库存'),
            'in_on_sale'=>$this->integer()->notNull()->defaultValue(1)->comment('是否上架'),
            'status'=>$this->integer()->notNull()->defaultValue(1)->comment('1正常 0回收站'),
            'sort'=>$this->integer()->notNull()->defaultValue(20)->comment('排序'),
            'inputtime'=>$this->integer()->notNull()->defaultValue(0)->comment('添加时间'),

        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('goods');
    }
}
