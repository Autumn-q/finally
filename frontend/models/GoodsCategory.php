<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "goods_category".
 *
 * @property integer $id
 * @property string $name
 * @property integer $tree
 * @property integer $parent_id
 * @property integer $lft
 * @property integer $rgt
 * @property string $intro
 * @property integer $depth
 */
class GoodsCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'goods_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tree', 'parent_id', 'lft', 'rgt', 'depth'], 'required'],
            [['tree', 'parent_id', 'lft', 'rgt', 'depth'], 'integer'],
            [['intro'], 'string'],
            [['name'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '分类名',
            'tree' => '树',
            'parent_id' => '父分类id',
            'lft' => '左边界',
            'rgt' => '右边界',
            'intro' => '简介',
            'depth' => '深度',
        ];
    }

    public function getChildren()
    {
        return $this->hasMany(self::className(),['parent_id'=>'id']);
    }
}
