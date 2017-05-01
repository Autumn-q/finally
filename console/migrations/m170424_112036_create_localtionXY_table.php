<?php

use yii\db\Migration;

/**
 * Handles the creation of table `localtionXY`.
 */
class m170424_112036_create_localtionXY_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('localtionXY', [
            'id' => $this->primaryKey(),
            'openId'=>$this->string(50),
            'location_X'=>$this->string(10),
            'location_Y'=>$this->string(10),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('localtionXY');
    }
}
