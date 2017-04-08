<?php

use yii\db\Migration;

/**
 * Handles the creation of table `goods_category`.
 */
class m170330_074642_create_goods_category_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('goods_category', [
            'id' => $this->primaryKey(),
            'name'=>$this->string(50)->comment('分类名'),
            'tree' => $this->integer()->notNull()->comment('树'),
            'parent_id'=>$this->integer()->notNull()->comment('父分类id'),
            'lft'=>$this->integer()->notNull()->comment('左边界'),
            'rgt'=>$this->integer()->notNull()->comment('右边界'),
            'intro'=>$this->text()->comment('简介'),
            'depth' => $this->integer()->notNull()->comment('深度'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('goods_category');
    }
}
