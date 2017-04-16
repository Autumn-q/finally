<?php
use yii\helpers\Html;
$this->registerCssFile('/style/fillin.css');

?>

<!-- 顶部导航 start -->
<div class="topnav" xmlns="http://www.w3.org/1999/html">
    <div class="topnav_bd w990 bc">
        <div class="topnav_left">

        </div>
        <div class="topnav_right fr">
            <ul>
                <li>您好，欢迎来到京西！[<a href="login.html">登录</a>] [<a href="register.html">免费注册</a>] </li>
                <li class="line">|</li>
                <li>我的订单</li>
                <li class="line">|</li>
                <li>客户服务</li>

            </ul>
        </div>
    </div>
</div>
<!-- 顶部导航 end -->

<div style="clear:both;"></div>

<!-- 页面头部 start -->
<div class="header w990 bc mt15">
    <div class="logo w990">
        <h2 class="fl"><a href="index.html"><?=Html::img('@web/images/logo.png')?></a></h2>
        <div class="flow fr flow2">
            <ul>
                <li>1.我的购物车</li>
                <li class="cur">2.填写核对订单信息</li>
                <li>3.成功提交订单</li>
            </ul>
        </div>
    </div>
</div>
<!-- 页面头部 end -->

<div style="clear:both;"></div>

<!-- 主体部分 start -->
<div class="fillin w990 bc mt15">
    <div class="fillin_hd">
        <h2>填写并核对订单信息</h2>
    </div>

    <form method="post" action="<?=\yii\helpers\Url::to(['order/add'])?>" name="foral">
        <input type="hidden" name="_csrf-frontend" value="<?=$token?>">
    <div class="fillin_bd">
        <!-- 收货人信息  start-->
        <div class="address">
            <h3>收货人信息 <a href="javascript:;" id="address_modify">[修改]</a></h3>
            <div class="address_info">
                <p>
                <?php foreach($addresses as $address):?>
                <input type="radio" value="<?=$address->id?>" name="address_id"/><?=$address->name.' '.$address->tel.' '.$address->province.' '.$address->city.' '.$address->area.' '.$address->address?></p>
                <?php endforeach;?>
            </div>

            <div class="address_select none">
                <ul>
                    <li class="cur">
                        <input type="radio" name="address" checked="checked" />王超平 北京市 昌平区 建材城西路金燕龙办公楼一层 13555555555
                        <a href="">设为默认地址</a>
                        <a href="">编辑</a>
                        <a href="">删除</a>
                    </li>
                    <li>
                        <input type="radio" name="address"  />王超平 湖北省 武汉市  武昌 关山光谷软件园1号201 13333333333
                        <a href="">设为默认地址</a>
                        <a href="">编辑</a>
                        <a href="">删除</a>
                    </li>

            </div>
        </div>
        <!-- 收货人信息  end-->

        <!-- 配送方式 start -->
        <div class="delivery">
            <h3>送货方式 <a href="javascript:;" id="delivery_modify">[修改]</a></h3>

            <div class="delivery_select">
                <table>
                    <thead>
                    <tr>
                        <th class="col1">送货方式</th>
                        <th class="col2">运费</th>
                        <th class="col3">运费标准</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach(\frontend\models\Order::$deliveries as $k=>$v):?>
                    <tr class="">
                        <td>
                            <input type="radio" name="delivery_id" value="<?=$k?>" checked="checked" class="delivery_radio"/><?=$v[0]?>
                        </td>
                        <td>￥<span><?=$v[1]?></span></td>
                        <td><?=$v[2]?></td>
                    </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- 配送方式 end -->

        <!-- 支付方式  start-->
        <div class="pay">
            <h3>支付方式 <a href="javascript:;" id="pay_modify">[修改]</a></h3>
            <div class="pay_select">
                <table>
                    <?php foreach(\frontend\models\Order::$payments as $k=>$v):?>
                        <tr class="">
                            <td class="col1"><input type="radio" name="pay_type_id" value="<?=$k?>" /><?=$v[0]?></td>
                            <td class="col2"><?=$v[1]?></td>
                        </tr>
                    <?php endforeach;?>
                </table>
            </div>
        </div>
        <!-- 支付方式  end-->

        <!-- 商品清单 start -->
        <div class="goods">
            <h3>商品清单</h3>
            <table>
                <thead>
                <tr>
                    <th class="col1">商品</th>
                    <th class="col3">价格</th>
                    <th class="col4">数量</th>
                    <th class="col5">小计</th>
                </tr>
                </thead>
                <tbody class="order">
                <?php foreach($rows as $row):?>
                <tr>
                    <td class="col1"><a href=""><?=Html::img(Yii::$app->params['adminUrl'].$row['logo'])?></a>  <strong><a href=""><?=$row['name']?></a></strong></td>
                    <td class="col3"><?=$row['shop_price']?></td>
                    <td class="col4"><?=$row['amount']?></td>
                    <td class="col5"><span><?=$row['shop_price']*$row['amount'].'.00'?></span></td>
                </tr>
                <?php endforeach?>
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="5">
                        <ul>
                            <li>
                                <span class="count">4 件商品，总商品金额：</span>
                                <em class="total">￥<span>5316.00</span></em>
                            </li>
                            <li>
                                <span>返现：</span>
                                <em class="back_money">-￥<span>2.00</span></em>
                            </li>
                            <li>
                                <span>运费：</span>
                                <em class="ems_money">￥<span>15.00</span></em>
                            </li>
                            <li>
                                <span>应付总额：</span>
                                <em class="all_money"></em>
                            </li>
                        </ul>
                    </td>
                </tr>
                </tfoot>
            </table>
        </div>
        <!-- 商品清单 end -->

    </div>

    <div class="fillin_ft">
        <a href="javascript:document.foral.submit()"></a>
        <p>应付总额：<strong><span class="all_money2"></span></strong></p>
    </div>
        </form>
</div>
