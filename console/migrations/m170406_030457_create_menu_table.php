<?php

use yii\db\Migration;

/**
 * Handles the creation of table `menu`.
 */
class m170406_030457_create_menu_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('menu', [
            'id' => $this->primaryKey(),
            'name'=>$this->string(50)->comment('菜单名'),
            'parent_id'=>$this->integer()->comment('父类id'),
            'description'=>$this->string(100)->comment('描述'),
            'url'=>$this->string(50)->comment('路由'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('menu');
    }
}
