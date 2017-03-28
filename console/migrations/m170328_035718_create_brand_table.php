<?php

use yii\db\Migration;

/**
 * Handles the creation of table `brand`.
 */
class m170328_035718_create_brand_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('brand', [
            'id' => $this->primaryKey()->comment('id'),
            'name'=>$this->string()->notNull()->comment('名称'),
            'intro'=>$this->text()->comment('简介'),
            'logo'=>$this->string(200)->notNull()->comment('logo'),
            'sort'=>$this->integer()->defaultValue(1)->comment('排序'),
            'status'=>$this->integer()->defaultValue(1)->comment('状态'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('brand');
    }
}
