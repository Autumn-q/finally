<?php

use yii\db\Migration;

/**
 * Handles the creation of table `article`.
 */
class m170328_112745_create_article_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('article', [
            'id' => $this->primaryKey(),
            'name'=>$this->string()->comment('文章名'),
            'article_category_id'=>$this->integer()->comment('文章分类id'),
            'intro'=>$this->text()->notNull()->comment('简介'),
            'status'=>$this->integer()->comment('状态'),
            'sort'=>$this->integer()->comment('排序'),
            'inputtime'=>$this->integer()->comment('录入时间'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('article');
    }
}
