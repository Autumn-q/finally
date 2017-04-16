<?php

namespace frontend\controllers;
use frontend\models\Cart;
use frontend\models\Goods;
use yii\web\Cookie;

class CartController extends \yii\web\Controller
{
    public $layout = 'cart';//指定布局文件
    //购物车功能
    public function actionIndex()
    {
        //判断是否有错误信息
        if(\Yii::$app->session->hasFlash('danger')){
            echo "<script>alert('".\Yii::$app->session->getFlash('danger')."')</script>";
        }
        //判断是否登录
        if(\Yii::$app->user->isGuest){
            //如果是游客,则直接从cookie中获取数据
            $cookies = \Yii::$app->request->cookies;
            $cookie = $cookies->get('cart');
            //判断是否有这个购物车
            if($cookie != null){
                $cart = unserialize($cookie->value);
            }else{
                $cart = [];
            }
        }else{
            //如果不是游客,则从数据库获取数据
            $member_id = \Yii::$app->user->id;
            $results = Cart::find()->where(['member_id'=>$member_id])->asArray()->all();
            $cart = [];
            //循环遍历拼接数组
            foreach($results as $result){
                $cart[$result['goods_id']] = $result['amount'];
            }

        }
        //根据商品id查出数据
        $rows = [];
        //商品数量
        $num = [];
        //商品总价
        $total = '';
        foreach($cart as $k=>$v){
            //循环查出
            //var_dump($k);
            $rows[] = Goods::find()->where(['id'=>$k])->all();
            //要购买商品对应的数量
            $num[$k] = $v;
            //计算出商品总价
            $shop_price = Goods::findOne(['id'=>$k]);
            $total += $v*$shop_price->shop_price;
        }
        $token = \Yii::$app->request->csrfToken;
        //var_dump($rows);exit;
        //var_dump($num);exit;
        //var_dump($total);exit;
        return $this->render('index',['rows'=>$rows,'num'=>$num,'total'=>$total,'token'=>$token]);
    }
    //购物车提示
    public function actionNotice($goods_id,$num)
    {
        //判断是否登录
        if(\Yii::$app->user->isGuest){
            $cookies = \Yii::$app->request->cookies;
            $cookie = $cookies->get('cart');

            //判断是否有这个cookie的数组
            if($cookie == null){
                $cart = [];
            }else{
                //反序列化成数组
                $cart = unserialize($cookie->value);
            }
            //判断是否有这个商品
            if(array_key_exists($goods_id,$cart)){
                //如果有就在原基础上增加
                $cart[$goods_id] = $cart[$goods_id]+$num;
            }else{
                //如果没有就新增
                $cart[$goods_id]=$num;
            }
            $cookies = \Yii::$app->response->cookies;
            //实例对象,设置属性
            $cookie = new Cookie([
                'name'=>'cart',
                'value'=>serialize($cart),
            ]);
            //保存cookie
            $cookies->add($cookie);
        }else{
            $member_id = \Yii::$app->user->id;
            //如果不是游客,那么商品信息应该保存到数据库
            //判断该用户是否有这个商品的购物车记录
            $model = new Cart();
            $result = $model->find()->where(['goods_id'=>$goods_id])->andWhere(['member_id'=>$member_id])->one();
            //var_dump($result);exit;
            if($result){
                //如果有就在原有的基础上加
                $result->amount += $num;
                $result->save();
            }else{
                //如果没有就添加
                $model->amount = $num;
                $model->goods_id = $goods_id;
                $model->member_id = $member_id;
                $model->insert();
            }

        }

        return $this->redirect(['cart/index?goods_id='.$goods_id]);
    }
    //修改数量和删除
    public function actionAjax($filter)
    {
        //接收ajax传值
        $goods_id = \Yii::$app->request->post('goods_id');
        $num = \Yii::$app->request->post('num');
        switch($filter) {
            case 'modify':
                if (\Yii::$app->user->isGuest) {
                    //实例cookie对象
                    $cookies = \Yii::$app->request->cookies;
                    $cookie = $cookies->get('cart');

                    //判断是否有这个cookie的数组
                    if ($cookie == null) {
                        $cart = [];
                    } else {
                        //反序列化成数组
                        $cart = unserialize($cookie->value);
                    }
                    //将数量放进数组中
                    $cart[$goods_id] = $num;

                    $cookies = \Yii::$app->response->cookies;
                    //实例对象,设置属性
                    $cookie = new Cookie([
                        'name' => 'cart',
                        'value' => serialize($cart),
                    ]);
                    //保存cookie
                    $cookies->add($cookie);

                } else {
                    //如果已经登录了
                    $member_id = \Yii::$app->user->id;
                    //如果不是游客,那么商品信息应该保存到数据库
                    //判断该用户是否有这个商品的购物车记录
                    $model = new Cart();
                    $result = $model->find()->where(['goods_id' => $goods_id])->andWhere(['member_id' => $member_id])->one();
                    //var_dump($result);exit;

                    $result->amount = $num;
                    $result->save();
                }
                return 'success';
                break;
            case 'del':
                $goods_id = \Yii::$app->request->post('goods_id');
                    if (\Yii::$app->user->isGuest) {
                        //实例cookie对象
                        $cookies = \Yii::$app->request->cookies;
                        $cookie = $cookies->get('cart');

                        //判断是否有这个cookie的数组
                        if ($cookie == null) {
                            $cart = [];
                        } else {
                            //反序列化成数组
                            $cart = unserialize($cookie->value);
                        }
                        unset($cart[$goods_id]);
                        $cookies = \Yii::$app->request->cookies;
                        $cookie = new Cookie([
                            'name' => 'cart',
                            'value' => serialize($cart),
                        ]);
                        $cookies->add($cookie);
                    } else {
                        //如果已经登录了
                        $member_id = \Yii::$app->user->id;
                        //如果不是游客,那么商品信息应该保存到数据库
                        //判断该用户是否有这个商品的购物车记录
                        $model = new Cart();
                        $result = $model->find()->where(['goods_id' => $goods_id])->andWhere(['member_id' => $member_id])->one();

                        $result->delete();
                    }
                    return 'success';
                    break;
                }

    }

}
