<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/22
 * Time: 11:02
 */

namespace frontend\controllers;


use EasyWeChat\Message\News;
use EasyWeChat\Message\Text;
use frontend\models\Goods;
use frontend\models\Locationxy;
use frontend\models\Member;
use frontend\models\MemberForm;
use frontend\models\Order;
use yii\helpers\Url;
use yii\web\Controller;
use EasyWeChat\Foundation\Application;

class WechatController extends Controller
{
    public $enableCsrfValidation = false;

    /*public function actionTest()
    {
        $api = "http://api.map.baidu.com/place/v2/search?query=酒店&page_size=10&page_num=0&scope=1&location=39.915,116.404&radius=2000&output=xml&ak=C4bSjmxiZYAiubEGGZadu2GeQOe1U1PZ";
        $rows = simplexml_load_string(file_get_contents($api));
        $content = '';
        foreach($rows->results as $row){

            foreach($row as $r){
                $content .= "您的周围有:".$r['name']
                    ."联系电话:".$r->telephone
                    ."地址:".$r->address;
            }
        }
        var_dump($content);exit;
    }*/
    public function actionIndex()
    {
        $app = new Application(\Yii::$app->params['wechat']);
        $server = $app->server;
        $server->setMessageHandler(function ($message) {
            switch ($message->MsgType) {
                case 'event':
                    switch ($message->Event) {
                        case 'subscribe':
                            # code...
                            break;
                        case 'CLICK'://自定义菜单点击事件
                            if ($message->EventKey == 'V1001_NEW_GOODS') {
                                return Goods::port();
                            }elseif($message->EventKey == 'V1001_HOT_GOODS'){
                                return Goods::hotSort();
                            }
                            break;
                        default:
                            # code...
                            break;
                    }
                    return '收到事件消息';
                    break;
                case 'text':
                    if ($message->Content == '最新商品') {
                        return Goods::port();
                    }elseif($message->Content == '最热商品'){
                        return Goods::hotSort();
                    }elseif($message->Content == '解除绑定'){
                        //先获取openid
                        $openId = $message->FromUserName;

                        $user = Member::findOne(['openId'=>$openId]);

                        if($user !== null){
                            $user->openId = 0;
                            $user->save(false);
                            //var_dump($user);exit;
                            return '解绑成功';
                        }

                        return '未绑定账号';
                    }elseif($message->Content == '帮助'){

                        $text = '帮助:回复信息可以使用该功能
1.最新商品
2.最热商品
3.解除绑定
4.发送坐标,再发送您要在周边搜索什么';
                        return $text;
                    }
                    //获取用户的openId
                    $openId = $message->FromUserName;
                    //根据openId去查询坐标
                    $location  = Locationxy::findOne(['openId'=>$openId]);
                    $location_x = $location->location_X;
                    $location_y = $location->location_Y;
                    $api = "http://api.map.baidu.com/place/v2/search?query=".$message->Content."&page_size=10&page_num=0&scope=1&location=39.915,116.404&radius=2000&output=xml&ak=C4bSjmxiZYAiubEGGZadu2GeQOe1U1PZ";
                    //$api = "http://api.map.baidu.com/place/v2/search?query=".$message->Content."&page_size=10&page_num=0&scope=1&location=".$location_x.",".$location_y."&radius=2000&output=xml&ak=C4bSjmxiZYAiubEGGZadu2GeQOe1U1PZ";
                    $rows = simplexml_load_string(file_get_contents($api));
                    $content = '';
                    foreach($rows->results as $row){

                        foreach($row as $r){
                            $content .= "

您的周围有:".$r->name
                                ."
联系电话:".$r->telephone
                                ."
地址:".$r->address;
                        }
                    }

                    return $content;
                    break;
                case 'location':
                    //获取用户发送的坐标和openId
                    $openId = $message->FromUserName;
                    //实例坐标对象,保存到数据库
                    $location = Locationxy::findOne(['openId'=>$openId]);
                    if(!$location){
                        $location = new Locationxy();
                        $location->openId = $openId;
                    }
                    $location->location_X = $message->Location_X;
                    $location->location_Y = $message->Location_X;
                    $location->save();
                    return '请再次输入您想查询的内容';
                    break;

                    /*<xml>
                    <ToUserName><![CDATA[toUser]]></ToUserName>
                    <FromUserName><![CDATA[fromUser]]></FromUserName>
                    <CreateTime>1351776360</CreateTime>
                    <MsgType><![CDATA[location]]></MsgType>
                    <Location_X>23.134521</Location_X>
                    <Location_Y>113.358803</Location_Y>
                    <Scale>20</Scale>
                    <Label><![CDATA[位置信息]]></Label>
                    <MsgId>1234567890123456</MsgId>
                    </xml>*/
                /*case 'image':
                    return '收到图片消息';
                    break;
                case 'voice':
                    return '收到语音消息';
                    break;
                case 'video':
                    return '收到视频消息';
                    break;

                case 'link':
                    return '收到链接消息';
                    break;
                // ... 其它消息
                default:
                    return '收到其它消息';
                    break;*/
            }
            // ...
        });


        $response = $server->serve();
        // 将响应输出
        $response->send();

        //return $_GET['echostr'];
    }

    //查询菜单
    public function actionGetMenus()
    {
        //实例菜单对象
        $app = new Application(\Yii::$app->params['wechat']);
        //实例菜单对象模块
        $menu = $app->menu;
        //调用查看方法
        $menus = $menu->all();
        var_dump($menus);
    }

    //设置菜单
    public function actionSetMenus()
    {
        //实例菜单对象
        $app = new Application(\Yii::$app->params['wechat']);
        //实例菜单对象模块
        $menu = $app->menu;
        //设置菜单
        $buttons = [
            [
                "type" => "click",
                "name" => "最新商品",
                "key" => "V1001_NEW_GOODS"
            ],
            [
                "type" => 'click',
                "name"=>"最热商品",
                "key"=>"V1001_HOT_GOODS"
            ],
            [
                "name" => "个人中心",
                "sub_button" => [
                    [
                        "type" => "view",
                        "name" => "我的信息",
                        "url" => Url::to(['wechat/user'], true),//这里需要绝对路径
                    ],
                    [
                        "type" => "view",
                        "name" => "我的订单",
                        "url" =>  Url::to(['wechat/order'], true),
                    ],
                    [
                        "type" => "view",
                        "name" => "绑定/解绑",
                        "url" =>  Url::to(['wechat/update'], true),
                    ],
                    /*[
                        "type" => "view",
                        "name" => "解除绑定",
                        "url" =>  Url::to(['wechat/unlink'], true),
                    ],*/
                ],
            ],
        ];
        //将菜单添加进去
        $r = $menu->add($buttons);
        var_dump($r);

    }
    public function actionOpenid()
    {
        //判断session中是否有该用户的openId
        if (!\Yii::$app->session->get('openId')) {
            //发起授权
            $app = new Application(\Yii::$app->params['wechat']);
            //将当前页的url保存到session中
            \Yii::$app->session->setFlash('back', 'wechat/user');
            $response = $app->oauth->redirect();
            $response->send();

        }
    }

    //用户个人信息
    public function actionUser()
    {
        //先获取openid
        self::actionOpenid();
        $openId = \Yii::$app->session->get('openId');
        //绑定前要先判断是否已绑定
        $rows = Member::findOne(['openId'=>$openId]);
        if($rows == null){
            //保存当前url到session
            \Yii::$app->session->set('url','wechat/user');
            return $this->redirect(['wechat/bang']);
        }

        return $this->render('user',['rows'=>$rows]);

    }
    /**
     * 注意:
     * 1.配置文件中的oauth要修改,尤其是回调页面的url
     * 2.在微信平台的页面授权地址要设置
     * 3.微信平台页面的授权地址不能有http://,只需要域名
     *
     */
    //网页授权回调地址
    public function actionCallback()
    {
        $app = new Application(\Yii::$app->params['wechat']);
        //获取已授权用户
        $user = $app->oauth->user();
        $user->id;
        //将用户的openId保存到session中
        \Yii::$app->session->set('openId', $user->id);
        //跳转回上一个页面
        if (\Yii::$app->session->hasFlash('back')) {

            return $this->redirect([\Yii::$app->session->getFlash('back')]);
        }

    }
    //我的订单
    public function actionOrder()
    {
        //先获取openid
        self::actionOpenid();
        $openId = \Yii::$app->session->get('openId');
        //绑定前要先判断是否已绑定
        $user = Member::findOne(['openId'=>$openId]);
        if($user == null){
            //保存当前url到session
            \Yii::$app->session->set('url','wechat/order');
            return $this->redirect(['wechat/bang']);
        }
        //查询订单
        $rows = Order::find()->where(['member_id'=>$user->id])->all();
        return $this->render('order',['rows'=>$rows]);
    }
    //账号绑定
    public function actionBang()
    {
        //先获取openid
        self::actionOpenid();
        $openId = \Yii::$app->session->get('openId');
        //绑定前要先判断是否已绑定
        $rows = Member::findOne(['openId'=>$openId]);
        if($rows == null){
                $model = new MemberForm();
                if(\Yii::$app->request->isPost && $model->load(\Yii::$app->request->post())){
                    //验证登录
                    if($model->weChatLogin($openId)){
                        \Yii::$app->session->setFlash('success','绑定成功');
                        //绑定后跳转
                        if (\Yii::$app->session->get('url')) {

                            return $this->redirect([\Yii::$app->session->get('url')]);
                        }
                    }

                }

            return $this->render('login',['model'=>$model]);
        }else{
            return '该账号已经绑定';
        }
    }
    //解除绑定
    public function actionUnlink()
    {
        //先获取openid
        self::actionOpenid();
        $openId = \Yii::$app->session->get('openId');
        //return var_dump($openId);exit;
        $user = Member::findOne(['openId'=>$openId]);

        if($user !== null){
            $user->openId = 0;
            $user->save(false);
            //var_dump($user);exit;
            \Yii::$app->session->setFlash('success','解绑成功');
            return $this->redirect(['wechat/bang']);
        }

        return '未绑定账号';

    }
    public function actionUpdate()
    {
        //先获取openid
        self::actionOpenid();
        $openId = \Yii::$app->session->get('openId');
        $user = Member::findOne(['openId'=>$openId]);
        return $this->render('update',['user'=>$user]);
    }
    public function actionEdit()
    {
        //先获取openid
        self::actionOpenid();
        $openId = \Yii::$app->session->get('openId');
        //查出数据
        $model = Member::findOne(['openId'=>$openId]);
//        $old_password = $model->password;

        if(\Yii::$app->request->isPost && $model->load(\Yii::$app->request->post())){

            /*if(!\Yii::$app->security->validatePassword($model->old_password,$old_password)){
                $model->addError('旧密码输入错误');exit;
            }*/
            \Yii::$app->session->setFlash('success','修改成功');
            $model->save(false);
            return $this->redirect(['wechat/user']);
        }
        return $this->render('edit',['model'=>$model]);
    }

}
        