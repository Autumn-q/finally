<?php

namespace backend\filters;
use yii\web\HttpException;

class AccessFilter extends \yii\base\ActionFilter
{
    public function beforeAction($action)
    {
        //判断当前用户是否有该操作权限
        if(!\Yii::$app->user->can($action->uniqueId)){
            //如果没有登录,就先跳转到登录页面
            if(\Yii::$app->user->isGuest){
                return $action->controller->redirect(\Yii::$app->user->loginUrl);
            }
            //没有就抛出异常返回false
            throw new HttpException(403,'对不起,您没有执行该操作的权限');
            return false;
        }

        return parent::beforeAction($action);
    }
}