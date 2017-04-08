<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "menu".
 *
 * @property integer $id
 * @property string $name
 * @property integer $parent_id
 * @property string $description
 * @property string $url
 */
class Menu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'menu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id','depth'], 'integer'],
            [['name', 'url'], 'string', 'max' => 50],
            [['description'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '菜单名',
            'parent_id' => '父类id',
            'description' => '描述',
            'url' => '路由',
            'depth'=>'深度',
        ];
    }
    public static function getMenuOption()
    {
        $arr = self::find()->where(['parent_id'=>0])->asArray()->all();
        $menu = ArrayHelper::map($arr,'id','description');
        $array = ['0'=>'顶级分类'];
        return ArrayHelper::merge($array,$menu);

    }
    public function getChildren()
    {

        //var_dump($this->hasMany(self::className(),['parent_id','id']));exit;
        return $this->hasMany(self::className(),['parent_id'=>'id']);
    }

}
