<?php

use yii\db\Migration;

/**
 * Handles the creation of table `article_category`.
 */
class m170328_105257_create_article_category_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('article_category', [
            'id' => $this->primaryKey(),
            'name'=>$this->string()->comment('分类名'),
            'intro'=>$this->text()->notNull()->comment('简介'),
            'status'=>$this->integer(4)->defaultValue(1)->comment('状态'),
            'sort'=>$this->integer(4)->defaultValue(20)->comment('排序'),
            'is_help'=>$this->integer(4)->defaultValue(1)->comment('是否是相关帮助')
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('article_category');
    }
}
