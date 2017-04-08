<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/5
 * Time: 14:19
 */

namespace backend\models;


use yii\base\Model;
use yii\helpers\ArrayHelper;

class RoleForm extends Model
{
    public $name;
    public $description;
    public $permission=[];
    const SCENARIO_ADD = 'add';

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        return ArrayHelper::merge($scenarios,[self::SCENARIO_ADD=>['name','description','permission']]);
    }


    public function rules()
    {
        return [
            [['name','description'],'required'],
            ['name','validateName','on'=>self::SCENARIO_ADD],
            ['permission','safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name'=>'名称',
            'description'=>'简介',
            'permission'=>'权限'
        ];
    }
    //自定义验证规则
    public function validateName($attribute,$params)
    {
        $authManager = \Yii::$app->authManager;

        if($authManager->getRole($this->$attribute)){

            $this->addError($attribute,'该角色已存在');
        }
    }
    //查出所有权限
    public static function getPermissionOptions()
    {
        $authManager = \Yii::$app->authManager;
        $rs = $authManager->getPermissions();
        return ArrayHelper::map($rs,'name','description');
    }
}