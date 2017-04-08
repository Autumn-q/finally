<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/5
 * Time: 13:11
 */

namespace backend\models;


use yii\base\Model;

class PermissionForm extends Model
{
    public $name;
    public $description;

    public function rules()
    {
        return [
          [['name','description'],'required'],
          ['name','validateName']
        ];
    }

    public function attributeLabels()
    {
        return [
          'name'=>'名称',
          'description'=>'简介',
        ];
    }
    //自定义验证规则
    public function validateName($attribute,$params)
    {
        $authManager = \Yii::$app->authManager;

        if($authManager->getPermission($this->$attribute)){
            $this->addError($attribute,'该权限已存在');
        }
    }
}