<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "brand".
 *
 * @property integer $id
 * @property string $name
 * @property string $intro
 * @property string $logo
 * @property integer $sort
 * @property integer $status
 */
class Brand extends \yii\db\ActiveRecord
{
    public static $status_name=['-1'=>'删除', 0=>'隐藏', 1=>'正常',];
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'brand';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name','status','logo'],'required'],
            [['name'],'unique','message'=>'已存在该品牌'],
            [['intro'], 'string'],
            [['sort'], 'integer'],
           // ['logo_file', 'file', 'extensions' => ['png','gif','jpg']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'id',
            'name' => '名称',
            'intro' => '简介',
            //'logo_file' => 'logo',
            'sort' => '排序',
            'status' => '状态',
        ];
    }
    //判断是本地图片还是网络图片
    public function imgUrl()
    {
        //判断是否有http,如果没有就在前面加上@web别名
        if(strpos($this->logo,'http://')===false){
            return '@web'.$this->logo;
        }
        return $this->logo;
    }
}
